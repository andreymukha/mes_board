<form method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="mes_title">Название объявления</label>
		<input id="mes_title" class="form-control" name="mes_title" type="text" value="<?=$message['title'];?>" placeholder="Название"/><br />

		<div class="radio">
			<? if(!empty($types) and is_array($types)): ?>
				<? foreach($types as $type): ?>
					<label for="mes_type">
						<? if($message['type_id'] == $type['type_id']): ?>
							<input type="radio" name="mes_type" checked value="<?=$type['type_id']?>"/> <?=$type['name']?>
						<?else:?>
							<input type="radio" name="mes_type" value="<?=$type['type_id']?>"/> <?=$type['name']?>
						<? endif; ?>
					</label>
				<? endforeach; ?>
			<? endif; ?>
		</div>

		<label for="mes_image">Загрузить изображение</label>

		<div class="img_prev"><img class="img-responsive img-thumbnail" src="<?= THUMBNAILS.$message['img']; ?>" alt=""></div>
		<input id="mes_image" class="mes_image" name="mes_image" type="file" value=""/><br />

		<!-- Аккордеон для дополнительных изображений -->
		<div class="panel-group" id="additional_img" role="tablist" aria-multiselectable="true">
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="heading">
					<h4 class="panel-title">
						<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse"
						   aria-expanded="false" aria-controls="collapseTwo">
							Загрузить дополнительные изображения
						</a>
					</h4>
				</div>
				<div id="collapse" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading">
					<div class="panel-body">
						<!--ФОРМА ДЛЯ ЗАГРУЗКИ КАРТИНОК-->
						<div class="additional_images">
							<?if(!empty($additional_images) and is_array($additional_images) and count($additional_images) > 0):?>
								<?foreach($additional_images as $cnt=>$img):?>
									<div class="img">
										<label for="add_mes_image<?=$cnt+1;?>">Дополнительное изображение <?=$cnt+1;?></label>
										<div class="img_prev"><img class="img-responsive img-thumbnail" src="<?= THUMBNAILS.$img; ?>" alt=""></div>
										<input id="add_mes_image<?=$cnt+1;?>" class="mes_image" name="additional_img[]" type="file"value=""/><br/>
									</div>
								<?endforeach;?>
							<?endif;?>
						</div>
						<input id="add_img" type="button" class="btn" value="Добавить дополнительное поле"/>
						<!--ФОРМА ДЛЯ ЗАГРУЗКИ КАРТИНОК-->
					</div>
				</div>
			</div>
		</div>
		<!-- Аккордеон для дополнительных изображений -->

		<label for="mes_categories">Выбрать категорию</label>
		<select name="mes_categories" id="mes_categories">
			<option value=""></option>
			<? if(!empty($categories) and is_array($categories)): ?>
				<? foreach($categories as $p_cat_id => $p_category): ?>
					<optgroup label="<?= $p_category['0'] ?>">
						<? foreach($p_category['parent'] as $cat_id => $category): ?>
							<? if($message['category_id'] == $cat_id): ?>
								<option selected value="<?=$cat_id?>">— <?=$category?></option>
							<?else:?>
								<option value="<?=$cat_id?>">— <?=$category?></option>
							<? endif; ?>
						<? endforeach; ?>
					</optgroup>
				<? endforeach; ?>
			<? endif; ?>
		</select>
		<br />

		<label for="mes_town">Город</label>
		<input id="mes_town" class="form-control" name="mes_town" type="text" value="<?=$message['town'];?>" placeholder="Город"/><br />

		<label for="mes_price">Цена</label>
		<input id="mes_price" class="form-control" type='text' name='mes_price' value="<?=$message['price']?>" placeholder="Цена"><br />

		<label for="mes_body">Текст объявления</label>
		<textarea name="mes_body" class="form-control" id="mes_body" cols="30" rows="10"><?=$message['body']?></textarea><br />

		<label for="capcha">Введите код с картинки</label><br />
		<img src="capcha.php"><br /><br />
		<input id="capcha" class="form-control" type='text' name='capcha'>
		<br />

		<input type="submit" name="add_message" class="btn btn-primary" value="Добавить объявление"/>
		<input type="hidden" name="message_id" value="<?=$message['post_id'];?>"/>
	</div>
</form>