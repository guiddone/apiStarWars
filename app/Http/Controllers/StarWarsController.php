<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Http;
use App\Starship;
use App\Vehicle;


class StarWarsController extends Controller
{
    /**
     * find.
      *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $type
     * @param  string  $name
     * @return \Illuminate\Http\Response
     **/
    //type can be starships or vehicles
    public function find($type,$name)
    {
        if($type=='starships' or $type=='vehicles'){
            $respuesta['results']=[];
            $busqueda = Http::get('https://swapi.dev/api/'.$type.'/?search='.$name);
            $result=$busqueda->json();

            foreach ($result['results'] as $b)
                if($b['name']==$name)
                    $respuesta['results']=$b;
            
            if($respuesta['results']){
                //in this part i ll check if the object is in the database. If it isnt i ll insert into db.
                $obj=$respuesta['results'];
                $id=$this->getIdFromUrl($obj['url']);
                
                if($type=='starships'){
                    $starship=Starship::find($id);
                    if(!$starship){
                        Starship::Create([
                            'id'=>$id
                        ]);
                        $count=0;
                    }else{
                        $count=$starship->count;
                    }
                }else{
                    $vehicle=Vehicle::find($id);
                    if(!$vehicle){
                        Vehicle::Create([
                            'id'=>$id
                        ]);
                        $count=0;
                    }else{
                        $count=$vehicle->count;
                    }
                }
                $respuesta['results']=['id'=>$id,
                    'name'=>$obj['name'],
                    'count'=>$count]; 
            } 
        }else{
            $respuesta['results']=['error'=>'Tipo Incorrecto, verificar!']; 
        }   
        return  $respuesta;
    }

    public function setCount($type,$name,$count,$mov=null)
    {
        if($type=='starships' or $type=='vehicles'){
            if($mov ==null or $mov=='increment' or $mov=='decrement'){
                $msg=['results'=>'No se encontraron datos'];
                $error='La cantidad fue actualizada con exito';
                $response=$this->find($type,$name);
            
                if($response['results'])
                {
                    $obj=$response['results'];
                    if($type=='starships'){
                        $s=Starship::find($obj['id']);
                        switch ($mov) {
                            case null:
                                $s->count=$count;
                                break;
                            case 'increment':
                                $s->count=$s->count+$count;
                                break;
                            case 'decrement':
                                if(($s->count-$count) >= 0)
                                    $s->count=$s->count-$count;
                                else
                                    $error="El stock no puede quedar en negativo.";

                                break;
                        }
                        
                        $s->save();
                        
                    }else{
                        $v=Vehicle::find($obj['id']);
                        switch ($mov) {
                            case null:
                                $v->count=$count;
                                break;
                            case 'increment':
                                $v->count=$v->count+$count;
                                break;
                            case 'decrement':
                                if(($v->count-$count) >= 0)
                                    $v->count=$v->count-$count;
                                else
                                    $error="El stock no puede quedar en negativo.";

                                break;
                        }
                        $v->save();
                    }
                    $msg=['results'=>$error];
                }
                return $msg;
            }else{
                return ['mensaje'=>'error, la direccion a la que quiere acceder no existe.'];
            }
        }else{
            return ['mensaje'=>'error: Tipo Incorrecto, verificar.'];
        }
    }
    
    
    public function getIdFromUrl($url)
    {
        //examples http://swapi.dev/api/starships/3/
        //         http://swapi.dev/api/vehicles/3/"
        if($url[21]=='s')
            $i=31;
        else
            $i=30;
        $id='';
        while($url[$i]!='/'){
            $id=$id.$url[$i];
            $i++;
            }
        return $id;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $name)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
