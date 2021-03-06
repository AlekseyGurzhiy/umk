<section class="section_add_file">
	<h1 class="UMK_h1">Электронный УМК : Загрузка файлов</h1>
	<div class="add_file">
		<form id="formAddFile" action="index.php" method="post" enctype="multipart/form-data">
			<table class="more_option_table">
				<tr> 
					<td colspan="2"> 
						<input type="text" name="add_file_beauty" class="add_file_beauty required" placeholder="Выберите файл..." autocomplete="off">
						<input type="file" name="add_file_real" class="add_file_real required">
					</td>
				</tr>
				<tr> 
					<td colspan="2"> <input type="text" name="add_file_name" class="add_file_name required" placeholder="Введите имя файла:" autocomplete="off"> </td>
				</tr>
				<tr> 
					<td colspan="2"> <div class="text_more_option"> Дополнительные параметры: </div> </td>
				</tr>
				<tr>
					<td class="w200"> 
						<div class="title">Авторы:</div>
						<input type="text" name="add_file_autors_t" class="add_file_autors_t" placeholder="Фамилия И.О." autocomplete="off">
						<select multiple name="add_file_autors_s" class="add_file_autors_s add_file_select" size="1">
						<?php mysqli_data_seek($query_autors, 0); ?>
						<?php while( $rows = mysqli_fetch_assoc($query_autors) ){ ?>
							<option value="<?php echo $rows['id']?>"><?php echo $rows['name']?></option>
						<?php $id_end = $rows['id']; } ?>
							<option value="not_autors" disabled> Автора в базе нет </option>
						</select> 
						<input type="hidden" id="<?php echo $id_end;?>" name="add_file_autors_h" class="add_file_autors_h" value="<?php echo $id_end;?>">
						<img src="img/add.png" class="add_autors">
					</td>
					<td class="bottom"> 
						<div class="clear_button clear_autors">очистить авторов</div>
						<div class="add_text_autors"></div>
						<input type="hidden" name="text_autors_h" class="text_autors_h">
					</td>
				</tr>
				<tr>
					<td class="w200">
						<div class="title">Ключевые слова:</div>
						<input type="text" name="add_file_keywords_t" class="add_file_keywords_t" placeholder="Слово..." autocomplete="off">
						<select multiple name="add_file_keywords_s" class="add_file_keywords_s add_file_select" size="1">
						<?php mysqli_data_seek($query_keywords, 0); ?>
						<?php while( $rows_keywords = mysqli_fetch_assoc($query_keywords) ){ ?>
							<option value="<?php echo $rows_keywords['id']?>"><?php echo $rows_keywords['title']?></option>
						<?php 
							$id_end_keywords = $rows_keywords['id']; 
							} 
						?>
							<option value="not_keywords" disabled> Cлова в базе нет </option>
						</select> 
						<input type="hidden" id="<?php echo $id_end_keywords;?>" name="add_file_keywords_h" class="add_file_keywords_h" value="<?php echo $id_end_keywords;?>">
						<img src="img/add.png" class="add_keywords">
					</td>
					<td class="bottom"> 
						<div class="clear_button clear_keywords">очистить ключевые слова</div>
						<div class="add_text_keywords"></div>
						<input type="hidden" name="text_keywords_h" class="text_keywords_h">
					</td>
				</tr>
				<tr>
					<td class="w200"> 
						<div class="title">Кафедра:</div>
					</td>
					<td class="bottom"> 
						<select name="add_file_kafedra_s" class="add_file_kafedra_s add_file_select" <?php echo ($_SESSION['srools'] == 'user')?'disabled':''?>>
							<option value="0"> Выбрать кафедру... </option>
							<?php mysqli_data_seek($query_pulpit, 0); ?>
							<?php while( $rows_pulpit = mysqli_fetch_assoc($query_pulpit) ){ ?>
								<option value="<?php echo $rows_pulpit['id'];?>" <?php echo ($rows_pulpit["id"] == $_SESSION['skaf'])?'selected':''?>> <?php echo $rows_pulpit['name'];?> </option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="w200"> 
						<div class="title">Факультет:</div>
					</td>
					<td class="bottom"> 
						<select name="add_file_facultet_s" class="add_file_select add_file_facultet_s">
							<option value="0"> Выбрать факультет... </option>
							<?php mysqli_data_seek($query_facultet, 0); ?>
							<?php while( $rows_facultet = mysqli_fetch_assoc($query_facultet) ){ ?>
								<option value="<?php echo $rows_facultet['id'];?>"> <?php echo $rows_facultet['name'];?> </option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr class="hide_show_table">
					<td class="w200"> 
						<div class="title"><span class="prof">Профессия</span>:</div>
					</td>
					<td class="bottom"> 
						<select name="add_file_speciality_s" class="add_file_speciality_s add_file_select">
							<option value="0"> Выбрать профессию... </option>
							<?php mysqli_data_seek($query_spec, 0); ?>
							<?php while( $rows_spec = mysqli_fetch_assoc($query_spec) ){ ?>
								<option class="kaf-<?php echo $rows_spec['id_facultet'];?>" value="<?php echo $rows_spec['id'];?>"> <?php echo $rows_spec['name_spec'];?> </option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr class="hide_show_table">
					<td class="w200"> 
						<div class="title profile_podgotovki">Специализация / <br> Профиль подготовки:</div>
					</td>
					<td class="bottom"> 
						<select name="add_file_profile_s" class="add_file_select add_file_profile_s">
							<option value="0"> Выбрать профиль... </option>
							<?php mysqli_data_seek($query_profile, 0); ?>
							<?php while( $rows_profile = mysqli_fetch_assoc($query_profile) ){ ?>
								<option class="kaf-<?php echo $rows_profile['id_facultet'];?>" value="<?php echo $rows_profile['id'];?>"> <?php echo $rows_profile['name'];?> </option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr class="hide_show_table">
					<td class="w200"> 
						<div class="title dol_kat">Должностная категория:</div>
					</td>
					<td class="bottom"> 
						<select name="add_file_job_s" class="add_file_select add_file_job_s">
							<option value="0"> Выбрать категорию... </option>
							<?php mysqli_data_seek($query_job, 0); ?>
							<?php while( $rows_job = mysqli_fetch_assoc($query_job) ){ ?>
								<option class="kaf-<?php echo $rows_job['id_kafedra'];?>" value="<?php echo $rows_job['id'];?>"> <?php echo $rows_job['name'];?> </option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="w200"> 
						<div class="title">Год:</div>
					</td>
					<td class="bottom"> 
						<select name="add_file_year_s" class="add_file_select add_file_year_s">
							<option value="0"> Выбрать год... </option>
							<?php for($i=0;$i<=20;$i++ ){ ?>
								<option value="<?php echo $this_year-$i;?>"> <?php echo $this_year-$i;?> </option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="w200"> 
						<div class="title">Раздел:</div>
					</td>
					<td class="bottom"> 
						<select name="add_file_section_s" class="add_file_select add_file_section_s">
							<option value="0"> Выбрать раздел... </option>
							<?php mysqli_data_seek($query_section, 0); ?>
							<?php while( $rows_section = mysqli_fetch_assoc($query_section) ){ ?>
								<option value="<?php echo $rows_section['id'];?>"> <?php echo $rows_section['name'];?> </option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="send_file" class="send_file" value="Загрузить"></td>
				</tr>
			</table>
			
		</form>
	</div>
</section>