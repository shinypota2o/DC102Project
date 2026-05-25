<?php
session_start();
$con = mysqli_connect("localhost","root","","bentaph");
?>
<html>
    <body>
        <h1>Items</h1>
        <form method="POST" enctype="multipart/form-data">
			Item Name : <input type="text" name ="itemname"></input></br>
			Category ID: <input type="number" name ="categoryid"></input></br>
			Description: <input type="text" name ="description"></input></br>
			Price: <input type="number" name ="price"></input></br>
			Quantity:<input type="number" name ="quantity"></input></br>
			Image:<input type="file" name ="image" accept=".jpg,.png"></input></br>
			<input type="submit" name ="btnsave" value="Add Item"></input>
			<?php
			if(isset($_POST["btnsave"])){
				$itemname= $_POST["itemname"];
				$categoryid= $_POST["categoryid"];
				$description= $_POST["description"];
				$price= $_POST["price"];
				$quantity= $_POST["quantity"];
				$image= "item_images/".basename($_FILES["image"]["name"]);
				
				if(move_uploaded_file($_FILES["image"]["tmp_name"], $image)){
					mysqli_query($con,"INSERT INTO items(itemname,categoryid,description,price,quantity,image) values ('$itemname','$categoryid','$description','$price','$quantity','$image')");
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
			</tr>
			<?php
			$q = mysqli_query($con, "SELECT * FROM items");
			while($row = mysqli_fetch_array($q)){
			?>
				<tr>	
					<td><?php echo $row["id"]; ?></td>
					<td><?php echo $row["itemname"]; ?></td>
					<td><?php echo $row["categoryid"]; ?></td>
					<td><?php echo $row["description"]; ?></td>
					<td><?php echo $row["price"];?></td>
					<td><?php echo $row["quantity"];?></td>
					<td><img src="<?php echo $row["image"]; ?>" style="width:50px;"/></td>
					<td>
						<a href="items_config.php?id=<?php echo $row["id"]; ?>">Manage</a>     
					</td>
				</tr> 
			<?php
			}
			?>
		</table>
	</body>
</html>