<?php

/**
 * This is the model class for table "receita_lei131".
 *
 * The followings are the available columns in table 'receita_lei131':
 * @property string $ano_refe
 * @property string $mes_refe
 * @property string $codi_enti
 * @property string $nome_enti
 * @property string $codi_rece
 * @property string $desc_rece
 * @property string $desc_forc
 * @property string $valo_arre
 * @property string $data_ulal
 * @property string $matr_usua
 */
class Receita extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'receita_lei131';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ano_refe', 'length', 'max'=>4),
			array('mes_refe, codi_enti', 'length', 'max'=>2),
			array('nome_enti', 'length', 'max'=>160),
			array('codi_rece', 'length', 'max'=>10),
			array('desc_rece, desc_forc', 'length', 'max'=>380),
			array('valo_arre', 'length', 'max'=>16),
			array('matr_usua', 'length', 'max'=>5),
			array('data_ulal', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ano_refe, mes_refe, codi_enti, nome_enti, codi_rece, desc_rece, desc_forc, valo_arre, data_ulal, matr_usua', 'safe', 'on'=>'search'),
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
			'ano_refe' => 'Ano Refe',
			'mes_refe' => 'Mes Refe',
			'codi_enti' => 'Codi Enti',
			'nome_enti' => 'Nome Enti',
			'codi_rece' => 'Codi Rece',
			'desc_rece' => 'Desc Rece',
			'desc_forc' => 'Desc Forc',
			'valo_arre' => 'Valo Arre',
			'data_ulal' => 'Data Ulal',
			'matr_usua' => 'Matr Usua',
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

		$criteria->compare('ano_refe',$this->ano_refe,true);
		$criteria->compare('mes_refe',$this->mes_refe,true);
		$criteria->compare('codi_enti',$this->codi_enti,true);
		$criteria->compare('nome_enti',$this->nome_enti,true);
		$criteria->compare('codi_rece',$this->codi_rece,true);
		$criteria->compare('desc_rece',$this->desc_rece,true);
		$criteria->compare('desc_forc',$this->desc_forc,true);
		$criteria->compare('valo_arre',$this->valo_arre,true);
		$criteria->compare('data_ulal',$this->data_ulal,true);
		$criteria->compare('matr_usua',$this->matr_usua,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Receita the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function afterFind(){
            $meses = array(
                '','Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho',
                'Agosto','Setembro','Outubro','Novembro','Dezembro'
            );
            if(isset($this->mes_refe))
                $this->mes_refe = $meses[$this->mes_refe];
        }
}
