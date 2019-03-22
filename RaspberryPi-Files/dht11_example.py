import RPi.GPIO as GPIO
import dht11
import time
import datetime
import requests

# Initialize GPIO
GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM)
GPIO.cleanup()

# DHT11 : pin 17
instance = dht11.DHT11(pin=17)

while True:
	# Read pin
    result = instance.read()
    
    if result.is_valid():
		# Print values
        print("Last valid input: " + str(datetime.datetime.now()))
        print("Temperature: %d C" % result.temperature)
        print("Humidity: %d %%" % result.humidity)
		
		# Put data into array 
        userdata = {"temp": result.temperature, "hum": result.humidity}
		
		# Send array to script as parameters
        resp = requests.post('http://whitewolf.be/IoT/IoT_Project/add_data.php',params=userdata)
		
	# Wait for 1 min
    time.sleep(60)
