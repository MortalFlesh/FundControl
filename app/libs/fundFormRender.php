<?php

class FundFormRender {

	/**
	 * @param string $title
	 * @param string $name
	 * @param string $value
	 * @param array $params
	 * @return FundFormRender
	 */
	public function renderTextFieldset($title, $name, $value = '', array $params = array()) {
		$this->renderInputWithFieldset('text', $title, $name, $value, $params);
		return $this;
	}

	/**
	 * @param string $type
	 * @param string $title
	 * @param string $name
	 * @param string $value
	 * @param array $params
	 * @return FundFormRender
	 */
	public function renderInputWithFieldset($type, $title, $name, $value, array $params) {
		?>
		<fieldset class="input-for">
			<legend class="input-for-title"><?=$title?></legend>
			<?
			$this->renderInput($type, $name, $value, $params);
			?>
			<input type="<?=$type?>" name="<?=$name?>" value="<?=$value?>" <?=implode(' ', $params)?> />
		</fieldset>
		<?
		return $this;
	}

	/**
	 * @param string $type
	 * @param string $name
	 * @param string $value
	 * @param array $params
	 * @return FundFormRender
	 */
	public function renderInput($type, $name, $value, array $params) {
		?><input type="<?=$type?>" name="<?=$name?>" value="<?=$value?>" <?=implode(' ', $params)?> /><?
		return $this;
	}

	/**
	 * @param string $title
	 * @param string $name
	 * @param string $value
	 * @param array $params
	 * @return FundFormRender
	 */
	public function renderPasswordFieldset($title, $name, $value = '', array $params = array()) {
		$this->renderInputWithFieldset('password', $title, $name, $value, $params);
		return $this;
	}

	/**
	 * @param string $title
	 * @param string $name
	 * @param string $value
	 * @param array $params
	 * @return FundFormRender
	 */
	public function renderNumberFieldset($title, $name, $value = '', array $params = array()) {
		$this->renderInputWithFieldset('tel', $title, $name, $value, $params);
		return $this;
	}

	/**
	 * @param string $title
	 * @param string $name
	 * @param array $values
	 * @param array $params
	 * @return FundFormRender
	 */
	public function renderSelectFieldset($title, $name, array $values, array $params = array()) {
		?>
		<fieldset class="input-for">
			<legend class="input-for-title"><?=$title?></legend>
			<select name="<?=$name?>" <?=implode(' ', $params)?>>
				<?
				foreach($values as $id => $value) {
					?><option value="<?=$id?>"><?=$value?></option><?
				}
				?>
			</select>
		</fieldset>
		<?
		return $this;
	}

	/**
	 * @param string $title
	 * @param string $name
	 * @return FundFormRender
	 */
	public function renderSubmitFieldset($title, $name) {
		?>
		<fieldset class="input-for last">
			<legend class="input-for-title hidden"></legend>
			<input type="submit" name="<?=$name?>" value="<?=$title?>" />
		</fieldset>
		<?
		return $this;
	}

	/**
	 * @param Closure $customRender
	 * @return FundFormRender
	 */
	public function renderCustom(Closure $customRender) {
		$customRender();
		return $this;
	}

	/**
	 * @param string $model
	 * @param string $title
	 * @param string $name
	 * @param string $placeHolder
	 * @param string $value
	 * @return FundFormRender
	 */
	public function renderTextModel($model, $title, $name, $placeHolder = '', $value = '') {
		$this->renderInput('text', $name, $value, array(
			'bs-form-control',
			'ng-model="' . $model . '"',
			'label="' . $title . '"',
			'label-class="col-xs-3 col-sm-2 col-lg-1"',
			'class="col-xs-9 col-sm-10 col-lg-11"',
			'placeholder="' . $placeHolder . '"',
		));
		return $this;
	}

	/**
	 * @param string $model
	 * @param string $title
	 * @param string $name
	 * @param string $placeHolder
	 * @param string $value
	 * @return FundFormRender
	 */
	public function renderPasswordModel($model, $title, $name, $placeHolder = '', $value = '') {
		$this->renderInput('password', $name, $value, array(
			'bs-form-control',
			'ng-model="' . $model . '"',
			'label="' . $title . '"',
			'label-class="col-xs-3 col-sm-2 col-lg-1"',
			'class="col-xs-9 col-sm-10 col-lg-11"',
			'placeholder="' . $placeHolder . '"',
		));
		return $this;
	}

	/**
	 * @param string $title
	 * @param string $name
	 * @param string $action
	 * @return FundFormRender
	 */
	public function renderSubmitModel($title, $name, $action) {
		?>
		<div bs-panel class="form-actions">
			<div content-for="navbarAction" duplicate>
				<button type="submit"
					class="btn btn-primary"
					name="<?=$name?>"
					<?=(empty($action) ? '' : 'ng-click="' . $action . '"')?>
				><?=$title?></button>
			</div>
		</div>
		<?
		return $this;
	}
}