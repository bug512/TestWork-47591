<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Error;
use App\Http\Resources\Success;
use App\Models\SiteCard;
use App\Http\Resources\SiteCardResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Class SiteCardController
 * @package App\Http\Controllers\API
 */
class SiteCardController extends Controller
{
    const ERROR_STATUS = 504;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return SiteCardResource::collection(SiteCard::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $type = $request->input('data.type');
        $action = $request->input('data.attributes.action');
        $attributes = $request->input('data.attributes');

        if (!$type || !$action || $type !== 'site_card' || $action !== 'create') {
            $error = new Error([
                'status' => self::ERROR_STATUS,
                'method' => 'store',
                'messages' => ['Invalid data type'],
            ]);
            return new JsonResponse($error->resource, self::ERROR_STATUS);
        }

        $validator = Validator::make($attributes, [
            'title' => 'required',
            'url' => 'required|url|unique:site_cards,url',
        ]);

        if ($validator->fails()) {
            $error = new Error([
                'status' => self::ERROR_STATUS,
                'messages' => $validator->getMessageBag(),
            ]);

            return new JsonResponse($error->resource, self::ERROR_STATUS);
        }

        $siteCard = SiteCard::create($attributes);

        if (!$siteCard) {
            $error = new Error([
                'status' => self::ERROR_STATUS,
                'messages' => ['Creation error'],
            ]);

            return new JsonResponse($error->resource, self::ERROR_STATUS);
        }

        $success = new Success([
            'message' => 'Successfully created',
        ]);

        return new JsonResponse($success->resource);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return SiteCardResource|JsonResponse
     */
    public function show($id)
    {
        $siteCard = SiteCard::find($id);
        if (!$siteCard) {
            $error = new Error([
                'id' => 3,
                'status' => self::ERROR_STATUS,
                'messages' => ['Site not found'],
            ]);

            return new JsonResponse($error->resource, self::ERROR_STATUS);
        }

        return new SiteCardResource($siteCard);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $type = $request->input('data.type');
        $action = $request->input('data.attributes.action');
        $attributes = $request->input('data.attributes');

        if (!$type || !$action || $type !== 'site_card' || $action !== 'update') {

            $error = new Error([
                'status' => self::ERROR_STATUS,
                'method' => 'update',
                'messages' => ['Invalid data type'],
            ]);
            return new JsonResponse($error->resource, self::ERROR_STATUS);
        }

        $siteCard = SiteCard::find($id);
        if (!$siteCard) {
            $error = new Error([
                'id' => 3,
                'status' => self::ERROR_STATUS,
                'messages' => ['Site not found'],
            ]);

            return new JsonResponse($error->resource, self::ERROR_STATUS);
        }

        $validator = Validator::make($attributes, [
            'title' => 'required',
            'url' => [
                'required',
                'url',
                Rule::unique('site_cards', 'url')->ignore($id),
            ],
        ]);

        if ($validator->fails()) {
            $error = new Error([
                'status' => self::ERROR_STATUS,
                'messages' => $validator->getMessageBag(),
            ]);

            return new JsonResponse($error->resource, self::ERROR_STATUS);
        }

        $siteCard->fill($attributes);

        $saved = $siteCard->save();

        if (!$saved) {
            $error = new Error([
                'status' => self::ERROR_STATUS,
                'messages' => ['Update error'],
            ]);

            return new JsonResponse($error->resource, self::ERROR_STATUS);
        }

        $success = new Success([
            'message' => 'Successfully updated',
        ]);

        return new JsonResponse($success->resource);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        $siteCard = SiteCard::find($id);
        if (!$siteCard) {
            $error = new Error([
                'id' => 3,
                'status' => self::ERROR_STATUS,
                'messages' => ['Site not found'],
            ]);

            return new JsonResponse($error->resource, self::ERROR_STATUS);
        }

        $deleted = $siteCard->delete();

        if (!$deleted) {
            $error = new Error([
                'status' => self::ERROR_STATUS,
                'messages' => ['Delete error'],
            ]);

            return new JsonResponse($error->resource, self::ERROR_STATUS);
        }

        $success = new Success([
            'message' => 'Removed successfully',
        ]);

        return new JsonResponse($success->resource);
    }
}
