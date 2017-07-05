package com.example.apple;

import android.support.v7.app.ActionBarActivity;
import android.content.Intent;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Spinner;

public class ManActivity extends ActionBarActivity {

	Spinner sp1,sp2,sp3,sp4,sp5;//宣告物件變數
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_man);//ManActivity所對應的佈局檔activity_man
		sp1=(Spinner)findViewById(R.id.spinner1);//依對應的ID來取得物件Spinner1
		sp2=(Spinner)findViewById(R.id.spinner2);//依對應的ID來取得物件Spinner2
		sp3=(Spinner)findViewById(R.id.spinner3);//依對應的ID來取得物件Spinner3
		sp4=(Spinner)findViewById(R.id.spinner4);//依對應的ID來取得物件Spinner4
		sp5=(Spinner)findViewById(R.id.spinner5);//依對應的ID來取得物件Spinner5
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.man, menu);
		return true;
	}
	public void goBack(View v){
		Intent it = new Intent(this, Name2Activity.class);//建立Intent並設定目標Name2Activity
		startActivity(it);//啟動Intent中的目標Name2Activity
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
