<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Students;

class StdController extends Controller
{


    public function __construct()
    {
        $this->middleware('jwt.auth',['only' => [
            'store','update','destroy']]);
    }

    public function index()
    {
        $students = Students::All();
        $response = [
            'Message' => 'Liste des etudiants',
            'liste' => $students
        ];
        return response()->json($response,200);
    }


    public function store(Request $request)
    {
        //validation des champs de la requête
        $this->validate($request,[
            'nom' => 'required|min:4',
            'prenom' => 'required|min:4',
            'formation' => 'required'
        ]);

        //Récupération
        $nom = $request->input('nom');
        $prenom = $request->input('prenom');
        $formation = $request->input('formation');

        //Insertion a la db

        $student = new Students([
            'nom'=>$nom,
            'prenom' => $prenom,
            'formation' => $formation
        ]);
        

        $code = 200;
        $message = $nom.' Ajouté avec succes !';

        if(!$student->save())
        {
            $code = 404;
            $message = ' Erreur a l\'insertion !';
        }

// Renvoyer une réponse
        $response = [
            'Message' => $message
        ];
        return response()->json($response,$code);
    
    }


    public function show($id)
    {
        $student = Students::find($id);

        if($student == null)
        {
            $response = [
                'Message' => 'Inexistant'
            ];
            return response()->json($response,404);  
        }

        $response = [
            'Student' => $student
        ];
        return response()->json($response,200);
    }


    public function update(Request $request, $id)
    {

        $student = Students::find($id);

        if($student == null)
        {
            $response = [
                'Message' => 'Inexistant'
            ];
            return response()->json($response,404);  
        }

        //validation des champs de la requête
        $this->validate($request,[
            'nom' => 'required|min:4',
            'prenom' => 'required|min:4',
            'formation' => 'required'
        ]);

        $nom = $request->input('nom');
        $prenom = $request->input('prenom');
        $formation = $request->input('formation');

        $msg = 'Donnees modifiées avec succés!';
        $code = 200;

        if(!$student->update(['nom' => $nom , 'prenom' => $prenom , 'formation' => $formation]))
        {
            $msg = 'Echec Update !';
            $code = 404;
        }
        $response = [
            'Message' => $msg
        ];
        return response()->json($response,$code);
    }


    public function destroy($id)
    {
        $student = Students::find($id);

        if($student == null)
        {
            $response = [
                'Message' => 'Inexistant'
            ];
            return response()->json($response,404);  
        }

        $msg = 'Supprimé avec succés!';
        $code = 200;

        if(!$student->delete())
        {
            $msg = 'Echec Delete !';
            $code = 404;
        }

        $response = [
            'Message' => $msg
        ];
        return response()->json($response,$code);
 
     }
}
