<?php

namespace App\Http\Controllers;

use App\Exceptions\UserAlreadyLikedPostException;
use App\Exceptions\UserLikeOwnPostException;
use App\Http\Requests\PostToggleReactionRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function list()
    {
        $posts = Post::withCount('likes')->with('tags')->paginate();

        return PostResource::collection($posts);
    }

    public function toggleReaction(PostToggleReactionRequest $request)
    {
        try {
            $post = Post::with(['likes'])->findOrFail($request->validated('post_id'));

            // user tries to like his own post
            throw_if(Gate::denies('like-post', $post), UserLikeOwnPostException::class);

            $userLiked = $post->likes()->where('user_id', Auth::id())->exists();

            if ($request->boolean('like')) {
                if ($userLiked) {
                    // User already liked the post
                    return response()->json([
                        'status' => Response::HTTP_BAD_REQUEST,
                        'message' => 'You already liked this post.',
                    ], Response::HTTP_BAD_REQUEST);
                }

                // Like the post
                $post->likes()->create([
                    'user_id' => Auth::id(),
                ]);

                return response()->json([
                    'status' => Response::HTTP_OK,
                    'message' => 'You liked this post successfully.',
                ]);
            } else {
                if (!$userLiked) {
                    // User has not liked the post yet
                    return response()->json([
                        'status' => Response::HTTP_BAD_REQUEST,
                        'message' => 'You have not liked this post yet.',
                    ], Response::HTTP_BAD_REQUEST);
                }

                // Unlike the post
                $post->likes->each->delete();

                return response()->json([
                    'status' => Response::HTTP_OK,
                    'message' => 'You unliked this post successfully.',
                ]);
            }
        } catch (UserLikeOwnPostException $e) {
            return response()->json([
                'status'  => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'You cannot like your post',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (UserAlreadyLikedPostException $e) {
            return response()->json([
                'status'  => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'You already liked this post',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status'  => Response::HTTP_NOT_FOUND,
                'message' => 'model not found',
            ], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
