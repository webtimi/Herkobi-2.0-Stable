<?php if(!class_exists('raintpl')){exit;}?><!DOCTYPE html>
					<li><a href="posts.php">DUYURULAR</a></li>
						<ul>
								<a href="products.php?id=<?php echo $value1["id"];?>" title="<?php echo $value1["category"];?>"><?php echo $value1["category"];?></a>
							</li>
						</ul>
                    <article class="group">
                        <?php if ($_GET) { ?>
						<h3><?php echo $category_name;?></h3>
						<?php } else { ?>
						<h3>ÜRÜNLER</h3>
						<?php } ?>
						<?php $counter1=-1; if( isset($products) && is_array($products) && sizeof($products) ) foreach( $products as $key1 => $value1 ){ $counter1++; ?>
                        <p class="product">
                            <a href="product.php?id=<?php echo $value1["id"];?>" title="<?php echo $value1["product"];?>"><?php echo $value1["product"];?></a>
                            <img src="<?php echo $value1["image"];?>" />
                        </p>
						<?php } ?>
                    </article>					