package com.example.apple;

import java.io.BufferedReader;
import java.io.DataOutputStream;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;

import android.app.Activity;
import android.content.Intent;
import android.net.Uri;
import android.net.Uri.Builder;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.ActionBarActivity;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

public class Name1Activity extends Activity {


	TextView tv1,tv2;//宣告物件變數
	EditText ed1,ed2;
	Button bt1,bt2;

	private void Initviews() {
	
	tv1=(TextView)findViewById(R.id.textView1);//依對應的ID來取得物件textview1
	tv2=(TextView)findViewById(R.id.textView2);//依對應的ID來取得物件textview2
	ed1=(EditText)findViewById(R.id.editText1);//依對應的ID來取得物件edittext1
	ed2=(EditText)findViewById(R.id.editText2);//依對應的ID來取得物件edittext2
	bt1=(Button)findViewById(R.id.button1);//依對應的ID來取得物件button1
	bt2=(Button)findViewById(R.id.button2);//依對應的ID來取得物件button2

	}
	public void gotoName2Activity(View v) {
		Intent it = new Intent(this, Name2Activity.class);//建立Intent並設定目標Name2Activity
		startActivity(it);//啟動Intent中的目標Name2Activity
	}
	public void web(View v) {
		Intent it = new Intent();//建立Intent物件
		it.setAction(Intent.ACTION_VIEW);//設定動作:顯示
		Uri ur = Uri.parse("http://192.168.0.124:100/SendText_web/app.php");
		//將網址轉換為Uri物件
		it.setData(ur);
		//設定資料:內含網址的Uri物件
		startActivity(Intent.createChooser(it, "請選擇執行程式"));
		//讓使用者選擇啟動適合Intent的Activity選單
	}

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_name1);//Name1Activity所對應的佈局檔activity_name1
		setTitle("請點歌") ;//設定title名
		Initviews();
		
		
		
		bt1.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				new  SendTextTask().execute(
				((EditText)findViewById(R.id.editText1)).getText().toString(),
				//找到物件Editext1並抓取其中的文字傳送到字串
				((EditText)findViewById(R.id.editText2)).getText().toString()
				//找到物件Editext2並抓取其中的文字傳送到字串
				);
				
			}
		});
	}
	private class SendTextTask extends AsyncTask<String, String, String> {
		// <傳入參數, 處理中更新介面參數, 處理後傳出參數>
		SendTextTask() {
			bt1.setEnabled(false);//使bt1無法使用
			
		}
	        		
	        		protected String doInBackground(String... params) {
	        return doPost(
	        		"http://192.168.0.124:100/SendText_web/putdata.php", //設定傳送檔案路徑
	        		new Builder().appendQueryParameter("歌名", params[0])//設定字串名及值
	        					 .appendQueryParameter("使用者", params[1])
	        		
	        		);
	    }

	    protected void onPostExecute(String result) {// 背景工作處理"後"需作的事
	    	bt1.setEnabled(true);//使bt1可使用
	    	Toast.makeText(Name1Activity.this, result, Toast.LENGTH_LONG).show();//顯示網頁回傳值

	    }
	    
	 }

	public String doPost(String sURL, Builder builder) {//宣告變數
		try {
			URL url = new URL(sURL);
			HttpURLConnection URLConn = (HttpURLConnection) url.openConnection();
			//建立一個HttpURLConnection物件，並利用URL的openConnection()來建立連線
			URLConn.setDoOutput(true);//設置輸入
			URLConn.setDoInput(true); // 設置輸出
			URLConn.setRequestMethod("POST");  //設置請求方式為POST
			URLConn.setUseCaches(false);////POST請求不能使用緩存
			URLConn.connect();// 連接及往服務端發送訊息
			DataOutputStream out = new DataOutputStream(//將文件名及長度傳给客户端
			URLConn.getOutputStream());
			out.writeBytes(builder.toString().substring(1));//字串轉布林
			out.flush();//進行清理缓存的操作
			out.close();//關閉對客户端的输出
			InputStream is = URLConn.getInputStream();// 這邊開始做接收工作
			BufferedReader rd = new BufferedReader(new InputStreamReader(is));
			// 為輸出創建BufferedReader
			String line;//宣告字串變數
			StringBuffer response = new StringBuffer();//創建一個新的StringBuffer
			while ((line = rd.readLine()) != null) {//使用循環來讀取獲得的數據
				response.append(line);
				response.append('\r');//我們在每一行後面加上一個"/n"來換行
			}
			rd.close();//關閉InputStreamReader
			return response.toString();//將response轉為字串
		} catch (Exception ex) {
			return "失敗";
		}
	}
	
}
