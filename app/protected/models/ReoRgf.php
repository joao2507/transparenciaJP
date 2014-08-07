<?php

/**
 * This is the model class for table "reo_rgf_lei131".
 *
 * The followings are the available columns in table 'reo_rgf_lei131':
 * @property string $codi_rela
 * @property string $codi_linh
 * @property string $tipo_linh
 * @property string $ano_refe
 * @property string $peri_gera
 * @property string $desc_linh
 * @property string $valo_1
 * @property string $valo_2
 * @property string $valo_3
 * @property string $valo_4
 * @property string $valo_5
 * @property string $valo_6
 * @property string $valo_7
 * @property string $valo_8
 * @property string $valo_9
 * @property string $valo_10
 * @property string $valo_11
 * @property string $valo_12
 * @property string $valo_13
 * @property string $valo_14
 * @property string $data
 */
class ReoRgf extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'reo_rgf_lei131';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codi_rela', 'length', 'max'=>3),
			array('codi_linh', 'length', 'max'=>30),
			array('tipo_linh, peri_gera', 'length', 'max'=>1),
			array('ano_refe', 'length', 'max'=>4),
			array('desc_linh', 'length', 'max'=>300),
			array('valo_1, valo_2, valo_3, valo_4, valo_5, valo_6, valo_7, valo_8, valo_9, valo_10, valo_11, valo_12, valo_13, valo_14', 'length', 'max'=>16),
			array('data', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codi_rela, codi_linh, tipo_linh, ano_refe, peri_gera, desc_linh, valo_1, valo_2, valo_3, valo_4, valo_5, valo_6, valo_7, valo_8, valo_9, valo_10, valo_11, valo_12, valo_13, valo_14, data', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codi_rela' => 'Codi Rela',
			'codi_linh' => 'Codi Linh',
			'tipo_linh' => 'Tipo Linh',
			'ano_refe' => 'Ano Refe',
			'peri_gera' => 'Peri Gera',
			'desc_linh' => 'Desc Linh',
			'valo_1' => 'Valo 1',
			'valo_2' => 'Valo 2',
			'valo_3' => 'Valo 3',
			'valo_4' => 'Valo 4',
			'valo_5' => 'Valo 5',
			'valo_6' => 'Valo 6',
			'valo_7' => 'Valo 7',
			'valo_8' => 'Valo 8',
			'valo_9' => 'Valo 9',
			'valo_10' => 'Valo 10',
			'valo_11' => 'Valo 11',
			'valo_12' => 'Valo 12',
			'valo_13' => 'Valo 13',
			'valo_14' => 'Valo 14',
			'data' => 'Data',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('codi_rela',$this->codi_rela,true);
		$criteria->compare('codi_linh',$this->codi_linh,true);
		$criteria->compare('tipo_linh',$this->tipo_linh,true);
		$criteria->compare('ano_refe',$this->ano_refe,true);
		$criteria->compare('peri_gera',$this->peri_gera,true);
		$criteria->compare('desc_linh',$this->desc_linh,true);
		$criteria->compare('valo_1',$this->valo_1,true);
		$criteria->compare('valo_2',$this->valo_2,true);
		$criteria->compare('valo_3',$this->valo_3,true);
		$criteria->compare('valo_4',$this->valo_4,true);
		$criteria->compare('valo_5',$this->valo_5,true);
		$criteria->compare('valo_6',$this->valo_6,true);
		$criteria->compare('valo_7',$this->valo_7,true);
		$criteria->compare('valo_8',$this->valo_8,true);
		$criteria->compare('valo_9',$this->valo_9,true);
		$criteria->compare('valo_10',$this->valo_10,true);
		$criteria->compare('valo_11',$this->valo_11,true);
		$criteria->compare('valo_12',$this->valo_12,true);
		$criteria->compare('valo_13',$this->valo_13,true);
		$criteria->compare('valo_14',$this->valo_14,true);
		$criteria->compare('data',$this->data,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ReoRgf the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
