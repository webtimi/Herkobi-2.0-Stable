<?php if(!class_exists('raintpl')){exit;}?><!DOCTYPE html>
					<li><a href="galleries.php">GALERİLER</a></li>
					<h3>Firma Bilgileri</h3>
					<table cellpadding="5" cellspacing="5" border="0">
						<tbody>
							<tr>
								<td>Firma Adı</td>
								<td><?php echo $fullname;?></td>
							</tr>
							<tr>
								<td>Vergi Dairesi</td>
								<td><?php echo $taxoffice;?></td>
							</tr>
							<tr>
								<td>Vergi No</td>
								<td><?php echo $taxnumber;?></td>
							</tr>							
						</tbody>
					</table>
					<h3>İletişim Bilgileri</h3>
					<table cellpadding="5" cellspacing="5" border="0">
						<tbody>
							<tr>
								<td>Adres</td>
								<td><?php echo $address;?></td>
							</tr>
							<tr>
								<td>İlçe</td>
								<td><?php echo $county;?></td>
							</tr>
							<tr>
								<td>İl</td>
								<td><?php echo $city;?></td>
							</tr>
							<tr>
								<td>Telefon</td>
								<td><?php echo $phone;?></td>
							</tr>							
						</tbody>
					</table>