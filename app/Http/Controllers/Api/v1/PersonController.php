<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\PersonResource;
use App\Http\Resources\PersonResourceCollection;
use App\Person;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PersonController extends Controller
{
    /**
     * @return PersonResourceCollection
     */
    public function index(): PersonResourceCollection
    {
        return new PersonResourceCollection(Person::paginate());
    }

    /**
     * @param Person $person
     * @return PersonResource
     */
    public function show(Person $person): PersonResource
    {
        return new PersonResource($person);
    }

    /**
     * @param Request $request
     * @return PersonResource
     */
    public function store(Request $request): PersonResource
    {
        // create that person
        $request->validate([
            'first_name'    => 'required',
            'last_name'     => 'required',
            'email'         => 'required',
            'phone'         => 'required',
            'city'          => 'required'
        ]);

        $person = Person::create($request->only(['first_name', 'last_name', 'email', 'phone', 'city']));

        return new PersonResource($person);
    }

    /**
     * @param Person $person
     * @param Request $request
     * @return PersonResource
     */
    public function update(Request $request, Person $person): PersonResource
    {
        //update that person
        $person->update($request->except('_token'));

        return new PersonResource($person);
    }

    public function destroy(Person $person)
    {
        $person->delete();

        return response()->json([
            'message' => 'Person deleted successfully!'
        ]);
    }
}
