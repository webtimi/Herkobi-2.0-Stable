<!DOCTYPE html>
                    <article class="group">
						<h3>ALBÜMLERİMİZ</h3>
						{loop="galleries"}
                        <p class="product">
                            <a href="gallery.php?id={$value.id}" title="{$value.album}">{$value.album}</a>
                            <img src="{$value.image}" />
                        </p>
						{/loop}
                    </article>					