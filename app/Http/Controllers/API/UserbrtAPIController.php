<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUserbrtAPIRequest;
use App\Http\Requests\API\UpdateUserbrtAPIRequest;
use App\Models\Userbrt;
use App\Repositories\UserbrtRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;



/**
 * Class UserbrtAPIController
 */
class UserbrtAPIController extends AppBaseController
{
    private UserbrtRepository $userbrtRepository;

    public function __construct(UserbrtRepository $userbrtRepo)
    {
        $this->userbrtRepository = $userbrtRepo;
    }

    /**
     * Display a listing of the Userbrts.
     * GET|HEAD /brt
     */
    public function index(Request $request)
    {
        $response = $this->userbrtRepository->getall();
        if ($response['status']) {
            return response()->json([
                'data' => $response['data'],
                'message' => $response['message'],
                'status' => true
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'message' => $response['message'],
                'data' => $response['data'],
                'status' => false
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Store a newly created Userbrt in storage.
     * POST /brt
     */
    public function store(CreateUserbrtAPIRequest $request)
    {
        $response = $this->userbrtRepository->createBrt($request);
        if ($response['status']) {
            return response()->json([
                'data' => $response['data'],
                'message' => $response['message'],
                'status' => true
            ], Response::HTTP_CREATED);
        } else {
            return response()->json([
                'message' => $response['message'],
                'data' => $response['data'],
                'status' => false
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Display the specified Userbrt.
     * GET|HEAD /brt/{id}
     */
    public function show($id)
    {
        $response = $this->userbrtRepository->getone($id);
        if ($response['status']) {
            return response()->json([
                'data' => $response['data'],
                'message' => $response['message'],
                'status' => true
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'message' => $response['message'],
                'data' => $response['data'],
                'status' => false
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified Userbrt in storage.
     * PUT/PATCH /brt/{id}
     */
    public function update($id, Request $request)
    {
        return $response = $this->userbrtRepository->update($request, $id);
        if ($response['status']) {
            return response()->json([
                'data' => $response['data'],
                'message' => $response['message'],
                'status' => true
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'message' => $response['message'],
                'data' => $response['data'],
                'status' => false
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove the specified Userbrt from storage.
     * DELETE /brt/{id}
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $response = $this->userbrtRepository->destroy($id);
        if ($response['status']) {
            return response()->json([
                'data' => $response['data'],
                'message' => $response['message'],
                'status' => true
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'message' => $response['message'],
                'data' => $response['data'],
                'status' => false
            ], Response::HTTP_NOT_FOUND);
        }
    }
}
