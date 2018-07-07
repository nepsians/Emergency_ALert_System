package com.example.nihal.getting_lat_and_long;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;

public class Register extends AppCompatActivity {

    EditText username,password;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);

        username=findViewById(R.id.user_name);
        password=findViewById(R.id.pass_word);
    }


    public void onReg(View view){
            String getUsername=username.getText().toString();
            String getPassword=password.getText().toString();
            String type="Register";
            BackgroundTask backgroundTask=new BackgroundTask(this);
            backgroundTask.execute(type,getUsername,getPassword);

    }
}
