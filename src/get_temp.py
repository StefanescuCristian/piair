#!/usr/bin/env python

import bme680
import time
import datetime
#!/usr/bin/env python
import mysql.connector

mydb = mysql.connector.connect(
  host="host",
  user="user",
  passwd="pass",
  database="db"
)

mycursor = mydb.cursor()

sensor = bme680.BME680()

# These oversampling settings can be tweaked to
# change the balance between accuracy and noise in
# the data.

sensor.set_humidity_oversample(bme680.OS_2X)
sensor.set_pressure_oversample(bme680.OS_4X)
sensor.set_temperature_oversample(bme680.OS_8X)
sensor.set_filter(bme680.FILTER_SIZE_3)
sensor.set_gas_status(bme680.ENABLE_GAS_MEAS)

print("\n\nInitial reading:")
for name in dir(sensor.data):
    value = getattr(sensor.data, name)

    if not name.startswith('_'):
        print("{}: {}".format(name, value))

sensor.set_gas_heater_temperature(320)
sensor.set_gas_heater_duration(150)
sensor.select_gas_heater_profile(0)

start_time = time.time()
curr_time = time.time()
burn_in_time = 300

burn_in_data = []

print('Collecting gas resistance burn-in data for 5 mins\n')
while curr_time - start_time < burn_in_time:
    curr_time = time.time()
    if sensor.get_sensor_data() and sensor.data.heat_stable:
        gas = sensor.data.gas_resistance
        burn_in_data.append(gas)
        print('Gas: {0} Ohms'.format(gas))
        time.sleep(1)

gas_baseline = sum(burn_in_data[-50:]) / 50.0

# Set the humidity baseline to 40%, an optimal indoor humidity.
hum_baseline = 40.0

# This sets the balance between humidity and gas reading in the
# calculation of air_quality_score (25:75, humidity:gas)
hum_weighting = 0.25

print('Gas baseline: {0} Ohms, humidity baseline: {1:.2f} %RH\n'.format(
    gas_baseline,
    hum_baseline))

print("\n\nPolling:")

try:
    while True:
        if sensor.get_sensor_data() and sensor.data.heat_stable:
			gas = sensor.data.gas_resistance
			gas_offset = gas_baseline - gas
			hum = sensor.data.humidity
			hum_offset = hum - hum_baseline

			# Calculate hum_score as the distance from the hum_baseline.
			if hum_offset > 0:
				hum_score = (100 - hum_baseline - hum_offset)
				hum_score /= (100 - hum_baseline)
				hum_score *= (hum_weighting * 100)

			else:
				hum_score = (hum_baseline + hum_offset)
				hum_score /= hum_baseline
				hum_score *= (hum_weighting * 100)

			# Calculate gas_score as the distance from the gas_baseline.
			if gas_offset > 0:
				gas_score = (gas / gas_baseline)
				gas_score *= (100 - (hum_weighting * 100))

			else:
				gas_score = 100 - (hum_weighting * 100)

			# Calculate air_quality_score.
			air_quality_score = hum_score + gas_score

			now = datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S")

			db_date = "{0}".format(now)
			db_temp = "{0:.2f}".format(sensor.data.temperature)
			db_pressure ="{0:.2f}".format(sensor.data.pressure)
			db_humidity = "{0:.2f}".format(sensor.data.humidity)
			db_airqual ="{0:.2f}".format(air_quality_score)

			sql = "INSERT INTO sensor (data, temperature, pressure, humidity, airq) VALUES (%s, %s, %s, %s, %s)"
			val = (now, db_temp, db_pressure, db_humidity, db_airqual)

			mycursor.execute(sql, val)
			mydb.commit()

			print("{0},{1:.2f},{2:.2f},{3:.2f},{4:.2f}".format(now, sensor.data.temperature, sensor.data.pressure, sensor.data.humidity, air_quality_score))
			time.sleep(1)

except KeyboardInterrupt:
	pass
