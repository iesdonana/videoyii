<?php

class Alquilados extends Alquiler

{

public function search($params)
{
    $query = Alquiler::find();

    // add conditions that should always apply here

    $dataProvider = new ActiveDataProvider([
        'query' => $query,
    ]);

    $this->load($params);

    if (!$this->validate()) {
        // uncomment the following line if you do not want to return any records when validation fails
        // $query->where('0=1');
        return $dataProvider;
    }

    // grid filtering conditions
    $query->andFilterWhere([
        'id' => $this->id,
        'socio_id' => $this->socio_id,
        'pelicula_id' => $this->pelicula_id,
        'precio_alq' => $this->precio_alq,
        'alquilado' => $this->alquilado,
        'devuelto' => $this->devuelto,
    ]);

    return $dataProvider;
}
