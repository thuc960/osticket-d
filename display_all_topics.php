    <div align="right">
	<table id="tt" class="easyui-datagrid" style="width:100%;height:450px"
			url="display_all_topics_sql.php"
			title="查詢系統" iconCls="icon-search" toolbar="#ta"
			pageSize=10
             pageNumber=1
             pageList="[10,20,30,50,80,100]"
			pagination="true">
		<thead>
			<tr>
				<th field="number" >ID</th>
                <th field="username" >User</th>
				<th field="subject">Issue</th>
				<th field="created" >Date On</th>
                <th field="lastupdate" >Last Update</th>
                <th field="statusname">Status</th>
                <th field="firstname">IT</th>         
			</tr>
		</thead>
	</table>
    </div>
	<div id="ta" style="padding:3px">
		
		
        <span><font style="font-family:微軟正黑體; font-size::12px;">開始日期：</font><input  id="date_submitted" style="line-height:26px;border:1px solid #ccc" class="easyui-datebox" value="">
		　<font style="font-family:微軟正黑體; font-size::12px;">結束日期：</font><input  id="enddate_submitted" style="line-height:26px;border:1px solid #ccc" class="easyui-datebox" value=""></span>
		
        <span>　　<font style="font-family:微軟正黑體; font-size:12px;">查詢需求者：</font></span>
        <input id="suser" style="line-height:26px;border:1px solid #ccc"/>
        <p></p><span>　　<font style="font-family:微軟正黑體; font-size:12px;">查詢類別：</font></span>
        <select id="cid" class="easyui-combobox" style="width:222px">
        	<option value="" selected>請選擇</option>
        	<option value="1">系統新需求 Project Request</option>
            <option value="2">事故 Incident</option>
            <option value="3">服務請求 Service Request</option>
        </select>
        <font style="font-family:微軟正黑體; font-size:12px;">查詢狀態：</font>
         <select id="stu" class="easyui-combobox" style="width:122px">
         	<option value="" selected>請選擇</option>
        	<option value="1">新問題</option>
            <option value="2">評估</option>
            <option value="3">成案</option>
            <option value="4">分析中</option>
            <option value="5">開發中</option>
            <option value="6">測試中</option>
            <option value="7">結案</option>
        </select>
        <span><font style="font-family:微軟正黑體; font-size:12px;">依摘要查詢：</font></span> 
        <input id="getsummary" style="line-height:26px;border:1px solid #ccc"/>
        <a href="#" style="color:#2272FF" class="easyui-linkbutton" onclick="doSearch()"><font style="font-family:微軟正黑體;font-size::12px;">查　詢</font></a>
        <hr/><p></p>
       　<!-- a href="indexcheck.html" style="color:#F49308" class="easyui-linkbutton"><font style="font-family:微軟正黑體; font-size::12px;">全部查詢</font></a-->
	</div>
    <p>
