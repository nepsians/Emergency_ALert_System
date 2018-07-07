package com.example.nihal.getting_lat_and_long;

import android.Manifest;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.location.Location;
import android.location.LocationManager;
import android.support.annotation.NonNull;
import android.support.v4.app.ActivityCompat;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;

import static com.example.nihal.getting_lat_and_long.R.id.longitude;

public class MainActivity extends AppCompatActivity {

        static final int REQUEST_LOCATION=1;
        LocationManager locationManager;
        EditText latitudes;
        EditText longitudes;
        Button btn;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        btn = findViewById(R.id.button);
        latitudes =findViewById(R.id.latitude);
        longitudes=findViewById(R.id.longitude);

        locationManager=(LocationManager) getSystemService(Context.LOCATION_SERVICE);
        btn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                getLocation();
            }
        });


    }
    public void getLocation(){

        if(ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION)
                != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(this,Manifest.permission.ACCESS_FINE_LOCATION)
                != PackageManager.PERMISSION_GRANTED){
            ActivityCompat.requestPermissions(this, new String[]{Manifest.permission.ACCESS_FINE_LOCATION}, REQUEST_LOCATION);
            Location location=locationManager.getLastKnownLocation(LocationManager.NETWORK_PROVIDER);
            //latitudes= findViewById(R.id.latitude);
            //longitudes=findViewById(R.id.longitude);
            latitudes.setText("Pls, Enable the location");
            longitudes.setText("Pls, Enable the location.");
        }
        else{
            Location location=locationManager.getLastKnownLocation(LocationManager.NETWORK_PROVIDER);
            if (location != null){
                double latti=location.getLatitude();
                double longi=location.getLongitude();
                latitudes= findViewById(R.id.latitude);
                longitudes=findViewById(R.id.longitude);

                latitudes.setText("Latitude: "+latti);
                longitudes.setText("Longitude: "+longi);






            }else{

                latitudes.setText("Unable to find the location.");
                longitudes.setText("Unable to find the location.");
            }


        }
    }

    public void upload(View view){
        String latis=latitudes.getText().toString();
        String longi=longitudes.getText().toString();
        BackgroundTask backgroundTask=new BackgroundTask(this);
        String type="upload";
        backgroundTask.execute(type,latis,longi);
    }


    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permission, @NonNull int[] grandResults){

        //super.onRequestPermissionsResult(requestCode,permission,grandResults);
        switch (requestCode){
            case REQUEST_LOCATION:
                getLocation();
                break;
        }
    }

    public void OnLogin(View view){
            String Latitude=latitudes.getText().toString();
            String Longitude=longitudes.getText().toString();
            String type="login";
        BackgroundTask backgroundTask=new BackgroundTask(this);
        backgroundTask.execute(type,Latitude,Longitude);

    }

    public void ToReg(View view){
        startActivity(new Intent(this,Register.class));

    }


    }


