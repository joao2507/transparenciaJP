<?php

/**
 * This is the model class for table "despesa_lei131".
 *
 * The followings are the available columns in table 'despesa_lei131':
 * @property string $ano_refe
 * @property string $mes_refe
 * @property string $codi_enti
 * @property string $nome_enti
 * @property string $desc_forc
 * @property string $nume_empe
 * @property string $ano_empe
 * @property string $data_empe
 * @property string $desc_tpem
 * @property string $nome_forn
 * @property string $codi_elem
 * @property string $desc_desp
 * @property string $desc_orga
 * @property string $desc_tpde
 * @property string $nume_proc
 * @property string $desc_tpli
 * @property string $nume_lici
 * @property string $nume_proc_lici
 * @property string $valo_empe
 * @property string $data_movi
 * @property string $desc_tpmo
 * @property string $nume_parc
 * @property string $valo_movi
 * @property string $data_ulal
 * @property string $matr_usua
 * @property string $desc_itee
 */
class Despesa extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'despesa_lei131';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ano_refe, ano_empe, nume_parc', 'length', 'max'=>4),
			array('mes_refe, codi_enti', 'length', 'max'=>2),
			array('nome_enti', 'length', 'max'=>160),
			array('desc_forc', 'length', 'max'=>380),
			array('nume_empe, nume_proc', 'length', 'max'=>6),
			array('desc_tpem, nume_proc_lici', 'length', 'max'=>30),
			array('nome_forn, desc_orga, desc_tpde', 'length', 'max'=>300),
			array('codi_elem', 'length', 'max'=>8),
			array('desc_desp', 'length', 'max'=>180),
			array('desc_tpli', 'length', 'max'=>100),
			array('nume_lici', 'length', 'max'=>10),
			array('valo_empe, valo_movi', 'length', 'max'=>16),
			array('desc_tpmo', 'length', 'max'=>60),
			array('matr_usua', 'length', 'max'=>5),
			array('data_empe, data_movi, data_ulal, desc_itee', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ano_refe, mes_refe, codi_enti, nome_enti, desc_forc, nume_empe, ano_empe, data_empe, desc_tpem, nome_forn, codi_elem, desc_desp, desc_orga, desc_tpde, nume_proc, desc_tpli, nume_lici, nume_proc_lici, valo_empe, data_movi, desc_tpmo, nume_parc, valo_movi, data_ulal, matr_usua, desc_itee', 'safe', 'on'=>'search'),
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
			'desc_forc' => 'Desc Forc',
			'nume_empe' => 'Nume Empe',
			'ano_empe' => 'Ano Empe',
			'data_empe' => 'Data Empe',
			'desc_tpem' => 'Desc Tpem',
			'nome_forn' => 'Nome Forn',
			'codi_elem' => 'Codi Elem',
			'desc_desp' => 'Desc Desp',
			'desc_orga' => 'Desc Orga',
			'desc_tpde' => 'Desc Tpde',
			'nume_proc' => 'Nume Proc',
			'desc_tpli' => 'Desc Tpli',
			'nume_lici' => 'Nume Lici',
			'nume_proc_lici' => 'Nume Proc Lici',
			'valo_empe' => 'Valo Empe',
			'data_movi' => 'Data Movi',
			'desc_tpmo' => 'Desc Tpmo',
			'nume_parc' => 'Nume Parc',
			'valo_movi' => 'Valo Movi',
			'data_ulal' => 'Data Ulal',
			'matr_usua' => 'Matr Usua',
			'desc_itee' => 'Desc Itee',
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
		$criteria->compare('desc_forc',$this->desc_forc,true);
		$criteria->compare('nume_empe',$this->nume_empe,true);
		$criteria->compare('ano_empe',$this->ano_empe,true);
		$criteria->compare('data_empe',$this->data_empe,true);
		$criteria->compare('desc_tpem',$this->desc_tpem,true);
		$criteria->compare('nome_forn',$this->nome_forn,true);
		$criteria->compare('codi_elem',$this->codi_elem,true);
		$criteria->compare('desc_desp',$this->desc_desp,true);
		$criteria->compare('desc_orga',$this->desc_orga,true);
		$criteria->compare('desc_tpde',$this->desc_tpde,true);
		$criteria->compare('nume_proc',$this->nume_proc,true);
		$criteria->compare('desc_tpli',$this->desc_tpli,true);
		$criteria->compare('nume_lici',$this->nume_lici,true);
		$criteria->compare('nume_proc_lici',$this->nume_proc_lici,true);
		$criteria->compare('valo_empe',$this->valo_empe,true);
		$criteria->compare('data_movi',$this->data_movi,true);
		$criteria->compare('desc_tpmo',$this->desc_tpmo,true);
		$criteria->compare('nume_parc',$this->nume_parc,true);
		$criteria->compare('valo_movi',$this->valo_movi,true);
		$criteria->compare('data_ulal',$this->data_ulal,true);
		$criteria->compare('matr_usua',$this->matr_usua,true);
		$criteria->compare('desc_itee',$this->desc_itee,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Despesa the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
