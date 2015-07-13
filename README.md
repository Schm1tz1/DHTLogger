[DHTLogger][1]
=========
A simple project for temperature/humidity-logging and display using DHTxx-Sensors and an ethernet-capable Arduino.

- Client-Side: Arduino Ethernet (or with wifi/ethernet shield) is reading a DHT-sensor and submitting data over HTTP-GET with a pre-shared key. You only need a working ethernet-interface and assign MAC/IP, that's it. The sensor is read out using the [Adafruit DHT-Sensor-Library][2], but can be easily adapted to use e.g. [TinyDHT][3]
- Server-Side and Plotting: A small PHP-Script receives the data sent from Arduino and writes to a CSV-File. Plotting is done using JavaScript with the [Dygraph][4] and PHP for file access.

[1]: https://github.com/Schm1tz1/DHTLogger 
[2]: https://github.com/adafruit/DHT-sensor-library
[3]: https://github.com/adafruit/TinyDHT
[4]: http://dygraphs.com
