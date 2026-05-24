<?php
session_start();
$con = mysqli_connect("localhost","root","","bentaph");
?>
<html>
    <body>
        <h1>Items</h1>
        <form method="POST" encytype="multipart/form-data" action="items.php">
			Itemname : <input type = "text"name ="Itemname"></input></br>
			Categoryid: <input type = "number"name ="Categoryid"></input></br>
			Description: <input type = "text"name ="Description"></input></br>
			Price: <input type ="number"name ="Price"></input></br>
			Quantity:<input type ="number"name ="Quantity"></input></br>
			Image:<input type ="file"name ="Image"accept=".jpg,png"></input></br>
			<input type = "submit" name ="btnsave"value="add"></input>

				<php?
				if(isset($_POST["btnsave"]))
				{
				$Itemname=$_POST["Itemname"];
				$Categoryid=$_POST["Categoryid"];
				$Description=$_POST["Description"];
				$Price=$_POST["Price"];
				$Quantity=$_POST["Quantity"];
				$Img= "cover/".basename($_FILES["Image"]["Name"]);
				
					if(move_uploaded_file($_FILES["Image"]["tmp_name"],$Image))
					{
						mysqli_query($con,"INSERT INTO items(id,Itemname,Categoryid,Price,Quantity,Img) values ('$id','$itemname',
						'$Description','$Price','$Img')");
				    }
                }
				?>
				
		</form>
		
		<table border ="1" cellpadding="5">
			<tr>
				<th>id</th>
				<th>Itemname</th>
				<th>Categoryid</th>
				<th>Description</th>
				<th>Price</th>
				<th>Quantity</th>
				<th>Image</th>
				<th>action</th>
				<?php
				$q = mysqli_query($con,"SELECT * FROM items");
				while($row = mysqli_fetch_array($q)){
				?>
			<tr>	
				<td><?php echo $row["id"];?></td>
				<td><?php echo $row["itemname"];?></td>
				<td><?php echo $row["categoryid"];?></td>
				<td><?php echo $row["description"];?></td>
				<td><?php echo $row["price"];?></td>
				<td><?php echo $row["quantity"];?></td>
				<td><img src="<?php echo $row["img"]; ?>" style="width:50px;"/></td>
				<td>
					<a href="update.php?id=<?php echo $row["id"]; ?>">Update</a>     
					<a href="delete.php?id=<?php echo $row["id"]; ?>">Delete</a>

				</td>
				
			</tr>
			<?php
			}
			?>
			
		</table>
	</body>
</html>