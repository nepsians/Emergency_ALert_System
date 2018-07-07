# Emergency_ALert_System

During Emergency moments, it is really hard to send the exact location of that place(or site) to the Ambulance. So, this Android App sends 
the Latitude and Longitude of the Emergency site to the nearest Ambulance. In this project, we have specified 10 Ambulance Location in the
mysql database. If the clinet sends their location, than the distance between client and each Ambulance is calucalted in KM, which are
than stored in an array. From that array of distance, the smallest value is choosen and the id of that Amublance is found out. Than using 
Firebase, we will send the Notification alerting the ambulance, so that immediate response can taken.
