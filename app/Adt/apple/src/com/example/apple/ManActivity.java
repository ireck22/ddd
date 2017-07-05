package com.example.apple;

import android.support.v7.app.ActionBarActivity;
import android.content.Intent;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Spinner;

public class ManActivity extends ActionBarActivity {

	Spinner sp1,sp2,sp3,sp4,sp5;//�ŧi�����ܼ�
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_man);//ManActivity�ҹ������G����activity_man
		sp1=(Spinner)findViewById(R.id.spinner1);//�̹�����ID�Ө��o����Spinner1
		sp2=(Spinner)findViewById(R.id.spinner2);//�̹�����ID�Ө��o����Spinner2
		sp3=(Spinner)findViewById(R.id.spinner3);//�̹�����ID�Ө��o����Spinner3
		sp4=(Spinner)findViewById(R.id.spinner4);//�̹�����ID�Ө��o����Spinner4
		sp5=(Spinner)findViewById(R.id.spinner5);//�̹�����ID�Ө��o����Spinner5
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.man, menu);
		return true;
	}
	public void goBack(View v){
		Intent it = new Intent(this, Name2Activity.class);//�إ�Intent�ó]�w�ؼ�Name2Activity
		startActivity(it);//�Ұ�Intent�����ؼ�Name2Activity
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
