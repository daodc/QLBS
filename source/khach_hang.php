<!DOCTYPE html>
<html>
<head>
	<title>[:. Quản Lý Bán Sữa .:]</title>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
	<meta name="description" content="Quản Lý Bán Sữa" />
	<meta name="keywords" content="Vinamilk,Nutifood,Abbort,Daisy,Dutch Lady,Dumex" />
	<meta name="SKYPE_TOOLBAR' content='SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
	<meta name="format-detection" content="telephone=no" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src='https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js'></script>
      <script src='https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js'></script>
    <![endif]-->
	<link rel="icon" href="img/front/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="./css/bootstrap.min.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="./css/bootstrap-theme.min.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="./css/reset-intervale.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="./css/common.css" type="text/css" media="screen" />
</head>
<body>	
	<div id="wrapper">
		<div id="header">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<h1>Quản Lý Bán Sữa</h1>
					</div>
				</div>
			</div>
		</div>
		<div id="main-content">
			<div class="container">	
				<div class="col-sm-2">
					<ul class="nav nav-pills nav-stacked">
					  	<li><a href="/hang_sua.php">Hãng sữa</a></li>
					  	<li class="active"><a href="/khach_hang.php">Khách hàng</a></li>
					  	<li><a href="/khach_hang_tuy_bien.php">Khách hàng</a></li>
					  	<li><a href="/luoi_phan_trang.php">Thông tin sữa</a></li>
					</ul>
				</div>
				<div class="col-sm-10">
					<h2 class="title">Thông tin khách hàng</h2>
					<?php		
						//ket no csdl
						$db = mysql_connect("localhost","root","");
						if(!$db){
							echo "Không thể kết nối được CSDL";
							exit;
						}
						mysql_select_db("ql_ban_sua");
						//fix loi utf8 trong mysql
						mysql_query("SET CHARACTER SET utf8");
						$result = mysql_query("SELECT * FROM khach_hang");
						//Xuất thông tin ra khi đã có dữ liệu
						if(mysql_num_rows($result)!=0)
						{
							echo "<div class='table-responsive'>";
								echo "<table class='table table-bordered'>";
									echo "<thead>";
									echo "<tr>";
									echo "<th class='text-center'>Mã KH</th>";
									echo "<th>Tên khách hàng</th>";
									echo "<th class='text-center'>Giới tính</th>";
									echo "<th>Địa chỉ</th>";
									echo "<th>Điện Thoại</th>";
									echo "</tr>";
									echo "</thead>";
									echo "<tbody>";

									$stt = 0;
									while($row = mysql_fetch_row($result))
									{
										$ma_khach_hang = $row[0];
										$ten_khach_hang = $row[1];
										$gioi_tinh = $row[2];
										$dia_chi = $row[3];
										$dien_thoai = $row[4];
										
										if($stt%2==0)
											echo "<tr class='success'>";
										else
										echo "<tr>";	
											echo "<th class='text-center'>$ma_khach_hang</th>";
											echo "<td>$ten_khach_hang</td>";
											echo "<td class='text-center'>$gioi_tinh</td>";
											echo "<td>$dia_chi</td>";
											echo "<td>$dien_thoai</td>";
										$stt=$stt+1;
										echo "</tr>";
									}
									echo "</tbody>";
								echo "</table>";
							echo "</div>";
						}	
					?>	
				</div>			
			</div>
		</div>
	</div>
	<div id="footer">
		<div class="container">			
			<div class="row">
				<div class="col-xs-12">
					<p>Copyright © Site name, 20XX</p>
				</div>
			</div>
		</div>
	</div>

</body>
</html>