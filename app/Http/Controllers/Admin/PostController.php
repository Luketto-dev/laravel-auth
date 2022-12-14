<?php

namespace App\Http\Controllers\Admin;
use App\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{

    // ritorna un elemento cercato per il suo slug
    private function findBySlug($slug){

        $post = Post::where("slug", $slug)->first();

        if (!$post) {
            abort(404);
        }

        return $post;
    }

    private function generateSlug($text){
        $toReturn = null;
        $counter = 0;
        do {
            // generiamo uno slug partendo dal titolo
            $slug = Str::slug($text);

            // se il counter è maggiore di zero, concateno il suo valore allo slug
            if ($counter > 0 ) {
                $slug .= "-" . $counter;
            }

            // controllo a db se esistye gia uno slug uguale
            $slug_exist = Post::where("slug", $slug)->first();
            
            if ($slug_exist) {
                // se esiste, incremento il contatore pert il ciclo successivo
                $counter ++;
            }else{
                // altrimenti salvo lo slug nei dati del nuovo post
                $toReturn = $slug;
            }
        } while ($slug_exist);

        return $toReturn;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy("created_at", "desc")->get();

        return view("admin.posts.index", compact("posts"));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.posts.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validare i dati ricevuti
        $validatedData = $request->validate([
            "title" => "required|min:10",
            "content" => "required|min:10"
        ]);

        // salvare a db i dati
        $post = new Post();

        $post-> fill($validatedData);

        $post->slug = $this->generateSlug($post->title);

        $post->save();

        //redirect su una pagina desiderata, di solito show
        return redirect()-> route("admin.posts.show", $post->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {

        $post = $this->findBySlug($slug);

        return view("admin.posts.show", compact("post"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $post = $this->findBySlug($slug);

        return view("admin.posts.edit", compact("post"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        // validare i dati ricevuti
        $validatedData = $request->validate([
            "title" => "required|min:10",
            "content" => "required|min:10"
        ]);

        $post = $this->findBySlug($slug);

        if ($validatedData["title"] !== $post->title) {
            //genero nuovo slug
            $post->slug = $this->generateSlug($validatedData["title"]);
        }
        $post->update($validatedData);

        return redirect()->route("admin.posts.show", $post->slug);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $post = $this->findBySlug($slug);

        $post->delete();

        return redirect()->route("admin.posts.index");
    }
}
