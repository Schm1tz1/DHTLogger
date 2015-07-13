#include <SPI.h>
#include <Ethernet.h>
#include "DHT.h"

// select pin and type of sensor
#define DHTPIN 2
//#define DHTTYPE DHT11   // DHT 11 
#define DHTTYPE DHT22   // DHT 22  (AM2302)
//#define DHTTYPE DHT21   // DHT 21 (AM2301)

DHT dht(DHTPIN, DHTTYPE);
EthernetClient tcli;

// enter your details here - Arduino MAC and hostname or IP of server
byte mac[] = { 0x72, 0xFC, 0x16, 0x00, 0xC8, 0x86 };
//IPAddress ip(192,168,1,111);
char serverName[] = "enter.yourserver.here";
//byte serverIP[] = {192,168,1,1};

long lastReadingTime = 0;
float temp = 0.0;
float humi = 0.0;

bool conn = false;

void setup() {
  dht.begin();
  // only (mac) for DHCP or (mac,ip) for static IP
  Ethernet.begin(mac);
  //Ethernet.begin(mac, ip);
  Serial.begin(9600);
  
  // connect to HOSTNAME or IP
  Serial.println("Initial connection to server...");
  //tcli.connect(serverIP, 80);
  tcli.connect(serverName, 80);
  delay(1000);
  lastReadingTime=millis();
}

void loop() { 

  if (millis() - lastReadingTime > 60000){ // default value is 60s interval for readout
      Serial.println("Reading sensor...");
      humi = dht.readHumidity();
      temp = dht.readTemperature();
  
      if (isnan(humi) || isnan(temp)) {
        Serial.println("Failed to read from DHT sensor!");
        return;
      }
      
      if(tcli.connected()) {
        conn=true;
        submitMeasuredValues();
        lastReadingTime = millis();
      }
      else {
        conn=false;
        Serial.println("connecting to server...");
        tcli.connect(serverName, 80);
        delay(1000);
      }
    }
    //listenForEthernetClients();
}

void submitMeasuredValues() {
  Serial.println("Value sent!");
  // this is where the magic happens ! Send values (temp) and (humi) over GET method. Authentification via pre-shared key (token)
  tcli.print("GET /addvalue.php?token=66efff4c945d3c3b87fc271b47d456db&value=");
  tcli.print(temp);
  tcli.print(",");
  tcli.print(humi);
  tcli.println(" HTTP/1.0");
  tcli.println("Host: enter.yourserver.here"); // be sure to enter the hostname/IP of your server here for a complete HTTP-request
  tcli.println("Connection: close");
  tcli.println();
  tcli.stop();
} 

