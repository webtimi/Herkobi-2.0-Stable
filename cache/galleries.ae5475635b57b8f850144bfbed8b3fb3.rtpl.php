<?php if(!class_exists('raintpl')){exit;}?><!DOCTYPE html>
                    <article class="group">
						<h3>ALBÜMLERİMİZ</h3>
						<?php $counter1=-1; if( isset($galleries) && is_array($galleries) && sizeof($galleries) ) foreach( $galleries as $key1 => $value1 ){ $counter1++; ?>
                        <p class="product">
                            <a href="gallery.php?id=<?php echo $value1["id"];?>" title="<?php echo $value1["album"];?>"><?php echo $value1["album"];?></a>
                            <img src="<?php echo $value1["image"];?>" />
                        </p>
						<?php } ?>
                    </article>					