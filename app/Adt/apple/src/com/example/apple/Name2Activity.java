package com.example.apple;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.ActionBarActivity;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.TextView;

public class Name2Activity extends ActionBarActivity {
	TextView tv1;
	ImageButton man, woman,team;
	Button bt1;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_name2);
		setTitle("歌曲辭典");
	}
	public void gotoName1Activity(View v) {
		Intent it = new Intent(this,Name1Activity .class);//建立Intent並設立目標Name1Activity
		
		startActivity(it);//啟動Intent中的目標Name1Activity
	}

	
	public void gotoManActivity(View v) {
		Intent it = new Intent(this, ManActivity.class);//建立Intent並設立目標ManActivity
		
		startActivity(it);//啟動Intent中的目標ManActivity
	}
	public void gotoWomanActivity(View v) {
		Intent it = new Intent(this, WomanActivity.class);//建立Intent並設立目標WomanActivity
		startActivity(it);//啟動Intent中的目標WomanActivity
	}

	public void gotoTeamActivity(View v){
		Intent it = new Intent(this, TeamActivity.class);//建立Intent並設立目標TeamActivity
		startActivity(it);//啟動Intent中的目標TeamActivity
	}
	
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();
        if (id == R.id.action_settings) {
            return true;
        }
        return super.onOptionsItemSelected(item);
    }
}
