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
	<?php
	/***************************************************************
	* Class: Pager
	* Methods:
	* findStart
	* findPages
	* pageList
	* nextPrev
	* Redistribute as you see fit
	***************************************************************/
		class Pager{
			/*************************
			*Ham int findStart(int limit)	
			* Tra ve dong bat dau cua trang duoc chon dua tren trang lay duoc va bien limit
			**************************/
			function findStart($limit){
				if((!isset($_GET['page'])) || ($_GET['page'] =="1")){
					$start = 0;
					$_GET['page'] = 1;
				}
				else{
					$start = ($_GET['page']-1) * $limit;
				}
				return $start;
			}
			/*************************
			*Ham int findPages(int count, int limits)	
			* Tra ve so luong trang can thiet dua tren tong so dong co trong table va limit
			**************************/
			function findPages($count, $limit){
				$pages = (($count % $limit) == 0) ? $count/$limit :floor($count / $limit) + 1;
				return $pages;
			}
			/*************************
			*Ham string pageList(int curpage, int pages)	
			* Tra ve danh sach trang theo dinh dang "Trang dau tien <[cac trang]> Trang cuoi cung"
			**************************/
			function pageList($curpage,$pages){
				$page_list = "";

				/*In trang dau tien va nhung link toi trang truoc neu can*/
				if(($curpage != 1) && ($curpage)){
					$page_list .= " <a href=\"".$_SERVER['PHP_SELF']."?page=1\" title=\"Trang đầu\"><<</a>";
				}
				if(($curpage-1)>0){
					$page_list .= "<a href=\"".$_SERVER['PHP_SELF']."?page=".($curpage-1)."\" title=\"Về trang trước\"><</a>";
				}
				/*In ra danh sach cac trang va lam cho trang hien tai dam hom va mat link o chan */
				for($i=1;$i<=$pages;$i++){
					if($i == $curpage){
						$page_list .= "<b>".$i."</b>";
					}
					else{
						$page_list .= "<a href=\"".$_SERVER['PHP_SELF']."?page".$i."\" title=\"Trang ".$i."\">".$i."</a>";
			
					}
					$page_list .= " ";
				}

				/*In linh cua trang tiep theo va trang cuoi cung neu can*/
				if(($curpage+1) <= $pages){
					$page_list .= " <a href=\"".$_SERVER['PHP_SELF']."?page=".($curpage+1)."\" title=\"Đến trang sau\">></a>";
				}
				if(($curpage != $pages) && ($pages !=0)){
					$page_list .= "<a href=\"".$_SERVER['PHP_SELF']."?page=".$pages."\" title=\"Trang cuối\">>></a> ";
				}
				$page_list .= "</td>\n";

				return $page_list;
			}
			/*************************************************************************
			* Ham string nextPrev (int curpage, int pages)
			* Returns "Previous | Next" string for individual pagination (it's a word!)
			**************************************************************************/
			
			function nextPrev($curpage, $pages){
				$next_prev = "";
				if(($curpage-1)<=0){
					$next_prev .= "Về trang trước";
				}
				else{
					$next_prev .= "<a href=\"".$_SERVER['PHP_SELF']."?page=".($curpage-1)."\" title=\"Về trang trước\">></a>";
				}
				$next_prev .= " | ";

				if(($curpage+1) > $pages){
					$next_prev .= "Đến trang sau";
				}
				else{
					$next_prev .= " <a href=\"".$_SERVER['PHP_SELF']."?page=".($curpage+1)."\">Đến trang sau</a>";
				}
				return $next_prev;
			}
		}
	?>
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
					  	<li><a href="/khach_hang.php">Khách hàng</a></li>
					  	<li><a href="/khach_hang_tuy_bien.php">Khách hàng</a></li>
					  	<li class="active"><a href="/luoi_phan_trang.php">Thông tin sữa</a></li>
					</ul>
				</div>
				<div class="col-sm-10">
					<h2 class="title">Lưới phân trang sữa</h2>
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

						//khai bao bien class Pager
						$p = new Pager;

						//Yeu cau gioi han mot trang co bao nhieu dong
						$limit = 5;

						//tim dong bat dau dua vao bien trang lay duoc (khai bao neu no chua co gia tri)
						$start = $p->findStart($limit);

						// Tim so dong cua bang nho cau lenh truy van
						$count = mysql_num_rows(mysql_query("SELECT * FROM sua"));

						//Tim so trang dua tren so dong vua co va gioi han cho mot trang
						$pages = $p->findPages($count,$limit);

						//dung start va limit de lay so mau tin trong khoang tu $start, va so luong mau tin tren mot dong la $limit

						$result = mysql_query("SELECT * FROM sua,hang_sua,loai_sua where sua.ma_hang_sua = hang_sua.ma_hang_sua and sua.ma_loai_sua = loai_sua.ma_loai_sua LIMIT ".$start.", ".$limit);

						//Xuất thông tin ra khi đã có dữ liệu
						if(mysql_num_rows($result)!=0)
						{
							echo "<div class='table-responsive'>";
								echo "<table class='table table-bordered'>";
									echo "<thead>";
									echo "<tr>";
									echo "<th class='text-center'>STT</th>";
									echo "<th>Tên Sữa</th>";
									echo "<th class='text-center'>Hãng Sữa</th>";
									echo "<th>Loại Sữa</th>";
									echo "<th>Trọng Lượng</th>";
									echo "<th>Đơn Giá</th>";
									echo "</tr>";
									echo "</thead>";
									echo "<tbody>";

									$stt = 1;
									while($row = mysql_fetch_object($result))
									{
										$mas = $row->Ma_sua;
										$ten_sua = $row->Ten_sua;
										$hang_sua = $row->Ma_hang_sua;
										$loai_sua = $row->Ten_loai;
										$trong_luong = $row->Trong_luong;
										$don_gia = $row->Don_gia;
										
										if($stt%2==0)
											echo "<tr class='success'>";
										else
										echo "<tr>";	
											echo "<th class='text-center'>$mas</th>";
											echo "<td>$ten_sua</td>";
											echo "<td class='text-center'>$hang_sua</td>";
											echo "<td>$loai_sua</td>";
											echo "<td>$trong_luong gram</td>";
											echo "<td>".number_format($don_gia,0,'.','.')." VND</td>";
										$stt=$stt+1;
										echo "</tr>";
									}
									echo "</tbody>";
								echo "</table>";
							echo "</div>";
						}	
						
						//Xuat danh sach trang
						$pagelist = $p->pageList($_GET['page'], $pages);
						echo "<p class='text-center'>";
						echo $pagelist;
						echo "</p>";
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