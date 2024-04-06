<?php



if (isset($_GET['trader'])&&is_numeric($_GET['trader'])&&$_GET['trader']>0 ) {
	$user_id  =intval($_GET['trader']);
//	$l='ar';
	//$dataArray=$_GET['traderData'];
include 'connect.php';
include 'include/functions/functions.php';
include '../lang.php';

$fetchTrData=fetch('*','user','user_id',$user_id);
//sum order_mostafed
$stmt=$conn->prepare(' SELECT sum(order_mostafed) from orders where trader_id=? and approve_date>0 ');
$stmt->execute(array($fetchTrData['user_id']));$sum_mostafed=$stmt->fetchColumn();


$stmt=$conn->prepare(' SELECT * from orders 
join items on items.item_id=orders.item_id
join user on user.user_id=orders.trader_id
join country on country.country_id=user.country_id
join state on state.state_id=user.state_id
join city on city.city_id=user.city_id
where orders.trader_id= ? and orders.approve_date>0 order by orders.approve_date desc  ');
$stmt->execute(array($user_id));
$details=$stmt->fetchAll(); 





require_once 'pdf/vendor/autoload.php';//__DIR__ . 

$mpdf = new \Mpdf\Mpdf(['setAutoTopMargin' => 'pad']);//start document & add top margin

/**** Header & Footer *****/
// Define the Header/Footer before writing anything so they appear on the first page
$mpdf->SetHTMLHeader(' <div style="text-align: center;font-weight: bold;">تقرير  عملاء مستفيد  </div>');
$mpdf->SetHTMLFooter('
<table width="100%">
    <tr>
        <td width="33%">{DATE j-m-Y}</td>
        <td width="33%" align="center">{PAGENO}/{nbpg}</td>
        <td width="33%" style="text-align: right;">تقرير  عملاء مستفيد  </td>
    </tr>
</table>');
/**** END Header & Footer ****/

$mpdf->autoScriptToLang = true;//for encoding
$mpdf->autoLangToFont = true;//for encoding //
$keep_table_proportions = true; //for table
$html='
        
	    
	    <div dir="rtl" class="containerDash details">  

		  <div dir="rtl">
		     	  <span>اسم العميل :'.$fetchTrData['commercial_name'].'</span> &emsp;&emsp;<span>التليفون  :</span>'.'0'.$fetchTrData['phone'].'<br>
			     <span>الدولة :'.getCountry($fetchTrData['country_id'],$l).'</span>&emsp;<span>المحافظة :'.getState($fetchTrData['state_id'],$l).'</span>&emsp;<span>المدينة :'.getCity($fetchTrData['city_id'],$l).'</span>&emsp;<span>العنوان  :'. $fetchTrData['address'].'</span>
			      <p>مستحقات مستفيد: <b>'.$sum_mostafed.'</b> ج.م.</p>
			    </div>

		  <div class="table-reponsive table-report">
		      <table dir="ltr" class="table-manage">
			   <thead>
					<tr>
						<td> مستفيد  </td>
						<td> المدينة  </td>
						<td> المحافظة  </td>
						<td> الدولة  </td>
						<td> تليفون  المشتري  </td>
						<td> اسم المشتري  </td>
						<td> تاريخ التحويل  </td>
						<td> كود الخصم  </td>
						<td> اسم المنتج  </td> 
				    </tr>
				</thead>
				<tbody>';
					
					if (!empty($details)) { 
						foreach ($details as $value) { 
							//mostafed profit 
                           $sum_mostafed=sumFromDb3('order_mostafed','orders','trader_id',$value['user_id'],'approve',1);
							?><?php
					$html.='<tr>
								<td>'. $value['order_mostafed'].'</td>
								<td>'. getCity($value['city_id'],$l).'</td>
								<td>'.getState($value['state_id'],$l).'</td>
								<td>'.getCountry($value['country_id'],$l).'</td>
								<td>'. '0'.$value['buyer_phone'].'</td>
								<td>'.$value['buyer_name'].'</td>
								<td>'.date('Y-m-d',$value['approve_date']).'</td>
								<td>'. $value['order_code'].'</td>
					        	<td>'.$value['title'].'</td>
					        </tr>';
					       
					    }
					 } 
				 $html.= '</tbody>
			   </table>

			   <div style="font-size:11pt;text-align:right;margin-top:20px" >
			   	<p>الرجاء مراجعة التقرير أعلاه والتواصل معنا على  الأرقام الاتية:</p>
			   	<span class="small">ادارة موقع مستفيد: 01013632800</span><br>
			   	<span class="small">يمكنكم تحويل مستحقات مستفيد إالينا عبر فودافون كاش على:  01013632800</span><br>

			   </div>
		    </div>
	    </div>


';

$stylesheet = file_get_contents('layout/css/backStyle.css');

$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML($html);
$mpdf->Output('mostafed-report.pdf', 'I');

}//END if(isset($_GET['']))	

