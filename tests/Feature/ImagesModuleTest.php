<?php

namespace Tests\Feature;

use App\Models\Image;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\TestResult;
use Tests\TestCase;

class ImagesModuleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function list_of_images_can_be_retrieved()
    {
        //Se muestran excepciones para ver correctamente el error
        $this->withoutExceptionHandling();

        //Autenticación de usuario para poder utilizar la función
        $this->actingAs($user = User::factory()->create());

        //Datos de prueba
        Image::factory()->count(3)->make();

        //Llamo la ruta
        $response = $this->get('/images');

        //Compruebo que la respuesta esté bien
        $response->assertOk();

        //Compruebo que retorne la vista correcta y tenga la variable de imágenes
        $images = Image::all();
        $response->assertViewIs('layouts.images.index');
        $response->assertViewHas('images', $images);
    }

    /** @test */
    public function an_image_can_be_retrieved(){
        //Se muestran excepciones para ver correctamente el error
        $this->withoutExceptionHandling();

        //Autenticación de usuario para poder utilizar la función
        $this->actingAs($user = User::factory()->create());

        //Datos de prueba
        $image = Image::factory()->create();

        //Llamo la ruta
        $response = $this->get('/images/' . $image->id);

        //Compruebo que la respuesta esté bien
        $response->assertOk();

        //Compruebo que retorne la vista correcta y tenga la variable de imagen
        $image = Image::first();
        $response->assertViewIs('layouts.images.show');
        $response->assertViewHas('image', $image);
    }

    /** @test */
    public function an_image_can_be_created()
    {
        //Se muestran excepciones para ver correctamente el error
        $this->withoutExceptionHandling();

        //Autenticación de usuario para poder utilizar la función
        $this->actingAs($user = User::factory()->create());

        //Envío un end-point http , para crear una nueva imagen sobre la ruta /images
        $response = $this->post('/images', [
                'name' => 'Test name',
                'description'=> 'Test description',
                'file-upload' => UploadedFile::fake()->image('image1.jpg')
                ]);

        //Compruebo que exista un registro en DB
        $this->assertCount(1,Image::all());

        $image = Image::first();

        //Confirmo que los atributos sean iguales
        $this->assertEquals($image->name, 'Test name');
        $this->assertEquals($image->description, 'Test description');

        //Compruebo que se redirija a la vista show luego de creado
        $response->assertRedirect('/images/'.$image->id);

    }

    /** @test */
    public function an_image_can_be_updated()
    {
        //Se muestran excepciones para ver correctamente el error
        $this->withoutExceptionHandling();

        //Autenticación de usuario para poder utilizar la función
        $this->actingAs($user = User::factory()->create());

        //Datos de prueba
        $image = Image::factory()->create();

        //Envío un end-point http , para crear una nueva imagen sobre la ruta /images
        $response = $this->put('/images/' . $image->id, [
            'name' => 'Test name',
            'description'=> 'Test description',
            'file-upload' => UploadedFile::fake()->image('image1.jpg')
        ]);

        //Compruebo que exista un registro en DB
        $this->assertCount(1,Image::all());

        //Se actualiza el modelo
        $image = $image->fresh();

        //Confirmo que los atributos sean iguales
        $this->assertEquals($image->name, 'Test name');
        $this->assertEquals($image->description, 'Test description');

        //Compruebo que se redirija a la vista show luego de creado
        $response->assertRedirect('/images/'.$image->id);
    }

    /** @test */
    public function an_image_can_be_deleted()
    {
        //Se muestran excepciones para ver correctamente el error
        $this->withoutExceptionHandling();

        //Autenticación de usuario para poder utilizar la función
        $this->actingAs($user = User::factory()->create());

        //Datos de prueba
        $image = Image::factory()->create();

        //Envío un end-point http , para crear una nueva imagen sobre la ruta /images
        $response = $this->delete('/images/' . $image->id);

        //Compruebo que no existan registros en DB dado que solo había uno
        $this->assertCount(0,Image::all());

        //Compruebo que se redirija a la vista show luego de creado
        $response->assertRedirect('/images');
    }

    /** @test */
    public function test_name_image_is_required()
    {
        //Autenticación de usuario para poder utilizar la función
        $this->actingAs($user = User::factory()->create());

        //Envío un end-point http , para crear una nueva imagen sobre la ruta /images
        $response = $this->post('/images', [
            'name' => '',
            'description'=> 'Test description',
            'file-upload' => UploadedFile::fake()->image('image1.jpg')
        ]);

        $response->assertSessionHasErrors(['name']);

    }

    /** @test */
    public function test_image_can_be_uploaded()
    {
        //Se muestran excepciones para ver correctamente el error
        $this->withoutExceptionHandling();

        //Autenticación de usuario para poder utilizar la función
        $this->actingAs($user = User::factory()->create());

        //Se crea la imagen para probar
        $fileImage = UploadedFile::fake()->image('image1.jpg');

        //Envío un end-point http , para crear una nueva imagen sobre la ruta /images
        $response = $this->post('/images', [
            'name' => 'Test name',
            'description'=> 'Test description',
            'file-upload' => $fileImage
        ]);

        //Compruebo que el archivo se almacenó
        Storage::disk('images')->assertExists(Auth::id() . '/' . $fileImage->hashName());

    }


}
