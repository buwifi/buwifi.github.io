---
layout: services
title:  UpWiFi
description: Monitor your Guest WiFi's key metrics in realtime
background: images/company/05_Dashboard.png
slogan: Monitor your Guest WiFi's key metrics in realtime
svg: images/icon_jd/network-check-svgrepo-com.svg
benefitsSelected: [measure_guestwifi, reduce_downtime, zabbix_alarm]

intro:
    slogan: Monitor Guest WiFi performance
    header: 
        - Guest WiFi plays an essential role in most venues. 
          Any downtime or interruption in connection can severely disrupt both the guest experience and critical business operations. 
          This is why maintaining the optimal performance of a Guest WiFi service should be a top priority.
        - <span class="text-primary fw-bold">UpWiFi</span> is a simple, scalable solution by offering an automated way to monitor your Guest WiFi's key metrics in realtime.
        - This tool offers an easy-to-use and cost-effective way to track key Guest WiFi parameters, and gain the insights you need for faster WiFi troubleshooting.
    image: images/company/upwifi.jpg

features: 
  - slogan: Easy installation
    header: Installing UpWiFi is pretty much plug-and-play.
    bullets:
      - BuWiFi will provide preconfigured Raspberry Pi box to you. It will have your SSID.
      - Place it in-store as close to an Access Point as possible for better measurements.
      - Power it up.
      - And that is it. Preconfigured box will start to take hourly measurements and send it to our Zabbix server. 
    image: images/company/raspberry-pi-3-model-b-plus.webp
  - slogan: Measure Guest WiFi key metrics
    header: Get insights from your Guest WiFi network and monitor performance in real-time.
    bullets: 
      - <strong>Uptime:</strong> Amount of time a guest WiFi is active and available for use
      - <strong>WiFi Signal Strength (dBm):</strong> It can hinge on many different factors, such as the number of devices on the network, background noise and interference, desired data rates, and the types of applications to be used.
      - <strong>Throughput (Mbps):</strong> The amount of data able to be transferred and received during a specific period of time. Download (DL) and Upload (UL) rates.
      - <strong>Latency (ms):</strong> Latency is a measurement of delay. The time it takes for a data packet to reach its destination after being sent.
    image: images/company/Coverage-Graphic.svg
  - slogan: Receive email alerts when something goes wrong.
    header:  Receive problem notification to detect and resolve issues faster.
    bullets: 
      - Get email notifications from Zabbix when the problem started and resolved.
      - <strong>Condition 1:</strong> No data collected for 2 hours.
      - <strong>Condition 2:</strong> Download speed is below limit. If average of last 2 hour download speed goes below average of daily download speed.
    image: images/company/alarmemail.jpeg
  - slogan: Data is provided by all familiar Zabbix web interface
    header: Zabbix is an enterprise-class open source distributed monitoring solution. It has flexible notification mechanism that allows users to configure e-mail based alerts for virtually any event. 
    bullets:
      - Strong data gathering and real-time graphing capabilities. Collect data from devices with Zabbix agent.
      - Highly configurable alerting. You can define very flexible problem thresholds, called triggers.
      - Gather and analyze accurate statistics and performance metrics, visualize it, get notified about current and potential issues without delay.
    image: images/company/04_Graphs.png
---


