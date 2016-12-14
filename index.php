<?php
/*论坛主页面*/
require('config/config.inc.php');

//取得当前页数
if (isset($_GET['page']) && (int)$_GET['page']>0) {//获取页码并检查是否非法
     $page = $_GET['page'];
 }else{
     $page = 1; //如果获取不到页码则显示第1页
 }

//每页最多显示的记录数
$each_page=EACH_PAGE;

//计算页面开始位置
if (!$page || $page==1) {
	$start=0;
}else{
	$offset=$page-1;
	$start=($offset*$each_page);
}
?>
<?php  include('header.inc.php') ?>
<h2>Goblin论坛</h2>
<p>
	<?php
	$sql="SELECT * FROM goblin_topic ORDER BY sticky<1 asc,`datetime` DESC  LIMIT $start,$each_page";
	$result=mysql_query($sql);
	?>
	<table class="table">
		<thead>
		<tr>
			<th width="60%" align="center"><strong>帖子</strong></th>
			<th width="8%" align="center"><strong>访问量</strong></th>
			<th width="8%" align="center"><strong>回复数</strong></th>
			<th width="24%" align="center"><strong>日期</strong></th>
		</tr>
		</thead>
		<tbody>
		<?php
		//循环输出记录数
		while($rows=mysql_fetch_array($result)){
		?>
		<tr>
			<td>
				<?php
				//如果是“置顶”的记录
				if ($rows['sticky']=='1') {
					?>
					<button type="button" class="btn btn-primary btn-xs">置顶</button>
					<?php
				}
				//如果是锁定的记录
				if ($rows['locked']=="1") {
					?>
					<button type="button" class="btn btn-primary btn-xs">锁定</button>
					<?php
				}
				?>
				<a href="topic/view_topic.php?id=<?php echo $rows['id'];?>"><?php echo $rows['topic'];?></a>
			</td>
			<td>
				<?php
				echo $rows['view'];//浏览量
				?>
			</td>
			<td>
				<?php
				echo $rows['reply'];//回复量
				?>
			</td>
			<td>
				<?php
				echo $rows['datetime'];//日期
				?>
			</td>
		</tr>
		<?php
		}//退出while循环
		?>
		<tr>
			<td colspan="5" align="right">
			<input type="button" onclick="location.href='topic/create_topic.php'" value="创建新帖子" class="btn btn-primary">
			</td>
		</tr>
		</tbody>
	</table>
	<?php
	//计算前一页
	if ($page>1) {
		$prevpage=$page-1;
	}
	//当前记录数
	$currentend=$start+EACH_PAGE;

	//取得所有的记录数
	$sql="SELECT COUNT(*) FROM goblin_topic";
	$result=mysql_query($sql);
	$row=mysql_fetch_row($result);
	$total=$row[0];
	$pageCount=ceil($total/$each_page);
	//计算后一页
	if ($total>$currentend) {
		if (!$page) {
			$nextpage=2;
		}else{
			$nextpage=$page+1;
		}
	}
	?>
</p>

<div>
	<ul class="pagination pagination-sm">
	<?php //显示分页连接的代码
        if($page== 1){//如果是第1页，则不显示第1页的链接
        echo '<li class="disabled"><span>&laquo;</span></li>';
        echo '<li class="active"><a href="#">1</a></li>';
    	}else{ 
        	echo '<li><a href="?page="'. ($page-1).'><span>&laquo;</span></a></li>';
        	echo '<li><a href="?page=1">1</a></li>';
        }
        for($i=2;$i<= $pageCount;$i++){  //设置数字页码的链接
        if ($i==$page){
        	echo '<li class="active"><a href="#">'.$i.'</a></li>';
        } 
        else{
        	echo " <li><a href='?page=".$i."'>".$i."</a></li> ";
        } 
        }
        if ($page == $pageCount) {
        	echo '<li class="disabled"><span>&raquo;</span></li>';
        }else{
        	echo '<li><a href="?page='.($page+1).'"><span>&raquo;</span></li>';
        }
        echo " &nbsp 共".$total. "条记录&nbsp";//共多少条记录
        echo " $page / $pageCount 页";//当前页面的位置
    ?>
    </ul>
    </div>

<h3>标志</h3>
<p>
	<button type="button" class="btn btn-primary btn-xs">置顶</button>&nbsp;置顶的帖子<br><br>	
	<button type="button" class="btn btn-primary btn-xs">锁定</button>&nbsp;锁定的帖子<br><br>	

	<?php
	//检索当前在线用户
	$sql="SELECT COUNT(*) FROM goblin_user";
	$result=mysql_query($sql);
	$row=mysql_fetch_row($result);
	$total_user=$row[0];
	?>
	共有<b><?php echo$total_user;  ?></b>位注册的用户
</p>
<?php
//引用公共尾部页面
include('config/footer.inc.php');
?>




