<!DOCTYPE html>
					<li><a href="posts.php">DUYURULAR</a></li>
						<ul>
								<a href="products.php?id={$value.id}" title="{$value.category}">{$value.category}</a>
							</li>
						</ul>
                    <article class="group">
                        <?php if ($_GET) { ?>
						<h3>{$category_name}</h3>
						<?php } else { ?>
						<h3>ÜRÜNLER</h3>
						<?php } ?>
						{loop="products"}
                        <p class="product">
                            <a href="product.php?id={$value.id}" title="{$value.product}">{$value.product}</a>
                            <img src="{$value.image}" />
                        </p>
						{/loop}
                    </article>					