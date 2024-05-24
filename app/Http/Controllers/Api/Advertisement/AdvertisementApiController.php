<?php

namespace App\Http\Controllers\Api\Advertisement;

use App\Enums\Advertisement\OfferStatusEnums;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Advertisement\AdvertisementApiRequest;
use App\Http\Requests\Api\Advertisement\ChatAdvertisementApiRequest;
use App\Http\Requests\Api\Advertisement\CommentAdvertisementApiRequest;
use App\Http\Requests\Api\Advertisement\FilterAdvertisementApiRequest;
use App\Http\Requests\Api\Advertisement\OfferAdvertisementApiRequest;
use App\Http\Requests\Api\Advertisement\ReportAdvertisementApiRequest;
use App\Http\Requests\Api\Advertisement\UpdateAdvertisementApiRequest;
use App\Http\Requests\Api\Advertisement\UpdateOfferAdvertisementApiRequest;
use App\Http\Resources\Api\Advertisement\AdvertisementApiResource;
use App\Http\Resources\Api\Advertisement\AdvertisementCommentApiResource;
use App\Http\Resources\Api\Advertisement\ChatAdvertisementApiResource;
use App\Http\Resources\Api\Advertisement\OfferAdvertisementApiResource;
use App\Models\Advertisement;
use App\Models\UserAdsComment;
use App\Services\Advertisement\AdvertisementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdvertisementApiController extends Controller
{
    public function index()
    {
        try {
            $user = auth('api')->user();
            $ads = (new AdvertisementService())->getUserAds($user);
            return AdvertisementApiResource::collection($ads);
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function create(AdvertisementApiRequest $request)
    {
        try {
            $user = auth('api')->user();
            // TODO:: check user availability to add new ads
            $advertisement = (new AdvertisementService())->addNewAdvertisement($user, $request->getDTO());
            return ResponseHelper::successResponse(
                data: [
                    'advertisement' => AdvertisementApiResource::make($advertisement)
                ]
            );
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function update(int $id, UpdateAdvertisementApiRequest $request)
    {
        try {
            $user = auth('api')->user();
            // TODO:: check user availability to add new ads
            $advertisementService = new AdvertisementService();
            $advertisement = $advertisementService->find($user, $id);
            if (!$advertisement) {
                return ResponseHelper::errorResponse(error: trans('api.not found'));
            }
            if ($advertisement->is_sold) {
                return ResponseHelper::errorResponse(error: trans('api.not allowed'));
            }
            $advertisement = $advertisementService->updateAds($advertisement, $request->getDTO());
            return ResponseHelper::successResponse(
                data: [
                    'advertisement' => AdvertisementApiResource::make($advertisement)
                ]
            );
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function chatWithAdmin(int $id, ChatAdvertisementApiRequest $request)
    {
        try {
            $user = auth('api')->user();
            $advertisementService = new AdvertisementService();
            $advertisement = $advertisementService->findToAdmin($id);
            if (!$advertisement) {
                return ResponseHelper::errorResponse(error: trans('api.not found'));
            }
            $advertisementService->addChat($user, $advertisement, $request->get('message'));
            return ResponseHelper::successResponse(
                data: [],
                message: trans('api.added successfully')
            );
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function listChatWithAdmin(int $id)
    {
        try {
            $user = auth('api')->user();
            $advertisementService = new AdvertisementService();
            $advertisement = $advertisementService->findToAdmin($id);
            if (!$advertisement) {
                return ResponseHelper::errorResponse(error: trans('api.not found'));
            }
            return ChatAdvertisementApiResource::collection($advertisementService->listChat($user, $advertisement));
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function addOffers(int $id, OfferAdvertisementApiRequest $request)
    {
        try {
            $user = auth('api')->user();
            $advertisementService = new AdvertisementService();
            $advertisement = $advertisementService->findPublic($id);
            if (!$advertisement || $advertisement->user_id == $user->id || $advertisement->is_sold) {
                return ResponseHelper::errorResponse(error: trans('api.not found'));
            }
            $result = $advertisementService->addOffer($user, $advertisement, (float)$request->get('offer'));
            if (!$result['status']) {
                return ResponseHelper::errorResponse(error: $result['message']);
            }
            return ResponseHelper::successResponse(
                data: [],
                message: $result['message']
            );
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function listOffers(int $id)
    {
        try {
            $user = auth('api')->user();
            $advertisementService = new AdvertisementService();
            $advertisement = $advertisementService->findPublic($id);
            if (!$advertisement || $advertisement->user_id == $user->id) {
                return ResponseHelper::errorResponse(error: trans('api.not found'));
            }
            return OfferAdvertisementApiResource::collection($advertisementService->listOffers($user, $advertisement));
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function updateOffers(int $id, int $offerId, UpdateOfferAdvertisementApiRequest $request)
    {
        try {
            $user = auth('api')->user();
            $advertisementService = new AdvertisementService();
            $advertisement = $advertisementService->findPublic($id);

            if (!$advertisement || $advertisement->user_id != $user->id || $advertisement->is_sold) {
                return ResponseHelper::errorResponse(error: trans('api.not found'));
            }

            $offer = $advertisementService->findOffer($offerId, $advertisement->user_id, $advertisement->id);
            if (!$offer) {
                return ResponseHelper::errorResponse(error: trans('api.not found'));
            }

            $advertisementService->updateOfferStatus($offer, OfferStatusEnums::from($request->get('status')));
            return ResponseHelper::successResponse(
                data: [],
                message: trans('api.updated successfully')
            );
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function details(int $id)
    {
        try {
            // TODO:: check user availability to add new ads
            $advertisement = (new AdvertisementService())->find(auth('api')->user(), $id);
            if (!$advertisement) {
                return ResponseHelper::errorResponse(error: trans('api.not found'));
            }
            return ResponseHelper::successResponse(
                data: [
                    'advertisement' => AdvertisementApiResource::make($advertisement)
                ]
            );
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function deleteAdsMedia(int $id, int $media_id)
    {
        try {
            $user = auth('api')->user();
            // TODO:: check user availability to add new ads
            $advertisementService = new AdvertisementService();
            $advertisement = $advertisementService->find($user, $id);
            if (!$advertisement) {
                return ResponseHelper::errorResponse(error: trans('api.not found'));
            }

            if ($advertisementService->deleteMedia($id, $media_id)) {
                return ResponseHelper::successResponse(data: [], message: trans('api.deleted successfully'));
            }

            return ResponseHelper::errorResponse(error: trans('api.can not delete'));
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function filter(FilterAdvertisementApiRequest $request)
    {
        try {
            $ads = (new AdvertisementService())->getHomeAdsToMobile();
            return ResponseHelper::successResponse(data: [
                'featured' => AdvertisementApiResource::collection($ads['featured']),
                'latest' => AdvertisementApiResource::collection($ads['latest']),
                'more' => AdvertisementApiResource::collection($ads['more']),
            ]);
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }


    public function filterHomeProducts(Request $request, string $type)
    {
        try {
            //feature/more/latest
            return AdvertisementApiResource::collection((new AdvertisementService())->filterAdsToMobile($request, $type));
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function moreAds(FilterAdvertisementApiRequest $request)
    {
        try {
            return AdvertisementApiResource::collection((new AdvertisementService())->getMoreAds($request->getDTO()));
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function relatedAds(Advertisement $advertisement)
    {
        try {
            return AdvertisementApiResource::collection((new AdvertisementService())->getRelatedAds($advertisement));
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function show(int $id)
    {
        try {
            $advertisement = (new AdvertisementService())->findActiveAds($id);
            if (!$advertisement) {
                return ResponseHelper::errorResponse(error: trans('api.not found'));
            }
            return ResponseHelper::successResponse(
                data: [
                    'advertisement' => AdvertisementApiResource::make($advertisement)
                ]
            );
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function addToFavourite(int $id)
    {
        try {
            $advertisement = (new AdvertisementService())->findActiveAds($id);
            if (!$advertisement) {
                return ResponseHelper::errorResponse(error: trans('api.not found'));
            }
            (new AdvertisementService())->addAdsToFavourite(auth('api')->user(), $advertisement);
            return ResponseHelper::successResponse(
                data: [],
                message: trans('api.added successfully')
            );
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function removeFromFavourite(int $id)
    {
        try {
            $advertisement = (new AdvertisementService())->findActiveAds($id);
            if (!$advertisement) {
                return ResponseHelper::errorResponse(error: trans('api.not found'));
            }
            (new AdvertisementService())->removeAdsFromFavourite(auth('api')->user(), $advertisement);
            return ResponseHelper::successResponse(
                data: [],
                message: trans('api.removed successfully')
            );
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function myFavourites()
    {
        try {
            $ads = auth('api')->user()->favouritesAds;
            return ResponseHelper::successResponse(
                data: [
                    'favourites' => AdvertisementApiResource::collection($ads)
                ],
            );
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function reportAds(int $id, ReportAdvertisementApiRequest $request)
    {
        try {
            $advertisementService = new AdvertisementService();
            $advertisement = $advertisementService->findActiveAds($id);
            if (!$advertisement) {
                return ResponseHelper::errorResponse(error: trans('api.not found'));
            }
            $advertisementService->reportAd(auth('api')->user(), $advertisement, $request->get('comment'));

            return ResponseHelper::successResponse(
                data: [],
                message: trans('api.added successfully')
            );
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function addComment(int $id, CommentAdvertisementApiRequest $request)
    {
        try {
            $advertisementService = new AdvertisementService();
            $advertisement = $advertisementService->findActiveAds($id);
            if (!$advertisement) {
                return ResponseHelper::errorResponse(error: trans('api.not found'));
            }
            $advertisementService->addComment(auth('api')->user(), $advertisement, $request->get('comment'), $request->get('parent'));

            return ResponseHelper::successResponse(
                data: [],
                message: trans('api.added successfully')
            );
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function listComments(int $id)
    {
        try {
            $advertisementService = new AdvertisementService();
            $advertisement = $advertisementService->findActiveAds($id);
            if (!$advertisement) {
                return ResponseHelper::errorResponse(error: trans('api.not found'));
            }
            return AdvertisementCommentApiResource::collection($advertisement->allParentComments()->with('user', 'relatedComments')->paginate(15));
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function updateComment(int $id, int $commentId, CommentAdvertisementApiRequest $request)
    {
        try {
            $advertisementService = new AdvertisementService();
            $advertisement = $advertisementService->findActiveAds($id);
            if (!$advertisement) {
                return ResponseHelper::errorResponse(error: trans('api.not found'));
            }
            $userComment = $advertisementService->getUserComment(auth('api')->user()->id, $advertisement->id, $commentId);
            if (!$userComment) {
                return ResponseHelper::errorResponse(error: trans('api.not found'));
            }
            if ($advertisementService->isCommentInPast($userComment)) {
                return ResponseHelper::errorResponse(error: trans('api.not allowed'));
            }
            $advertisementService->updateComment($userComment, $request->get('comment'));
            return ResponseHelper::successResponse(
                data: [],
                message: trans('api.updated successfully')
            );
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function deleteComment(int $id, int $commentId)
    {
        try {
            $advertisementService = new AdvertisementService();
            $advertisement = $advertisementService->findActiveAds($id);
            if (!$advertisement) {
                return ResponseHelper::errorResponse(error: trans('api.not found'));
            }
            $userComment = $advertisementService->getUserComment(auth('api')->user()->id, $advertisement->id, $commentId);
            if (!$userComment) {
                return ResponseHelper::errorResponse(error: trans('api.not found'));
            }
            if ($advertisementService->isCommentInPast($userComment)) {
                return ResponseHelper::errorResponse(error: trans('api.not allowed'));
            }
            $advertisementService->deleteComment($userComment);
            return ResponseHelper::successResponse(
                data: [],
                message: trans('api.deleted successfully')
            );
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function reportComment(int $id, int $commentId, ReportAdvertisementApiRequest $request)
    {
        try {
            $advertisementService = new AdvertisementService();
            $advertisement = $advertisementService->findActiveAds($id);
            if (!$advertisement) {
                return ResponseHelper::errorResponse(error: trans('api.not found'));
            }
            $reportedComment = $advertisementService->findComment($commentId);
            $user = auth('api')->user();
            if (!$reportedComment || $reportedComment->user_id == $user->id) {
                return ResponseHelper::errorResponse(error: trans('api.not found'));
            }
            $advertisementService->reportComment($user, $advertisement, $reportedComment, $request->get('comment'));

            return ResponseHelper::successResponse(
                data: [],
                message: trans('api.added successfully')
            );
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function followComment(int $id, int $commentId)
    {
        try {
            $advertisementService = new AdvertisementService();
            $advertisement = $advertisementService->findActiveAds($id);
            if (!$advertisement) {
                return ResponseHelper::errorResponse(error: trans('api.not found'));
            }
            $reportedComment = $advertisementService->findComment($commentId);
            $user = auth('api')->user();
            if (!$reportedComment || $reportedComment->user_id == $user->id) {
                return ResponseHelper::errorResponse(error: trans('api.not found'));
            }

            $advertisementService->followComment($user, $advertisement, $reportedComment);

            return ResponseHelper::successResponse(
                data: [],
                message: trans('api.added successfully')
            );
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function unFollowComment(int $id, int $commentId)
    {
        try {
            $advertisementService = new AdvertisementService();
            $advertisement = $advertisementService->findActiveAds($id);
            if (!$advertisement) {
                return ResponseHelper::errorResponse(error: trans('api.not found'));
            }
            $reportedComment = $advertisementService->findComment($commentId);
            $user = auth('api')->user();
            if (!$reportedComment || $reportedComment->user_id == $user->id) {
                return ResponseHelper::errorResponse(error: trans('api.not found'));
            }

            $advertisementService->unFollowComment($user, $advertisement, $reportedComment);

            return ResponseHelper::successResponse(
                data: [],
                message: trans('api.deleted successfully')
            );
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function purchasedProduct(int $id)
    {
        try {
            $user = auth('api')->user();
            $advertisementService = new AdvertisementService();
            $advertisement = $advertisementService->findActiveAds($id);
            if (!$advertisement) {
                return ResponseHelper::errorResponse(trans('api.not found'));
            }
            if ($advertisement->user_id == $user->id) {
                return ResponseHelper::errorResponse(trans('api.not allowed'));
            }

            if ($advertisementService->purchaseProduct($user, $advertisement)) {
                return ResponseHelper::successResponse(data: [], message: trans('api.added successfully'));
            } else {
                return ResponseHelper::errorResponse(trans('api.not allowed'));
            }
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function addAction(int $id, string $action)
    {
        try {
            $advertisementService = new AdvertisementService();
            $advertisement = $advertisementService->findActiveAds($id);
            if (!$advertisement) {
                return ResponseHelper::errorResponse(trans('api.not found'));
            }

            $user = auth('api')->user();
            if ($advertisement->user_id == $user->id) {
                return ResponseHelper::errorResponse(trans('api.not allowed'));
            }

            if (!$advertisementService->isValidAction($action)) {
                return ResponseHelper::errorResponse(trans('api.not allowed'));
            }

            $advertisementService->addActionToAdvertisement($user, $advertisement, $action);
            return ResponseHelper::successResponse(data: [], message: trans('api.added successfully'));
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }

    }
}
