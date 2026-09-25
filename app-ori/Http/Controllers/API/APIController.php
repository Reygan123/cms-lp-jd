<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Agenda;
use App\Models\Program;
use App\Models\Unggulan;
use App\Models\Facility;
use App\Models\Pricing;
use App\Models\Benefit;
use App\Models\Testimony;
use App\Models\Portofolio;
use App\Models\Dukungan;
use App\Models\Partner;
use App\Models\Legal;
use App\Models\Ourteam;
use App\Models\Slider;
use App\Models\Pixel;
use App\Models\Ganalytics;
use App\Models\Welcomechat;
use App\Models\Identity;

/**
 * @OA\Info(
 *     title="Jatidiri APP",
 *     version="0.1",
 *     description="Dokumentasi API Jatidiri App",
 * )
 */
class APIController extends Controller
{
    
    /**
     * @OA\Get(
     *     path="/api/post",
     *     summary="Ambil daftar post",
     *     tags={"Post"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Cari berdasarkan judul atau isi",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil daftar post"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Post::with(['category', 'user:id,name,email'])->orderBy('pub_date', 'desc');

        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;

            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%')
                ->orWhere('content', 'like', '%' . $keyword . '%');
            });
        }

        $posts = $query->paginate(10);

        return response()->json($posts, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/post/{slug}",
     *     summary="Ambil detail post berdasarkan slug",
     *     tags={"Post"},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         description="Slug dari post",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data post"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post tidak ditemukan"
     *     )
     * )
     */
    public function show($slug)
    {
        $post = Post::with(['category', 'user:id,name,email'])->where('slug', $slug)->first();

        return response()->json($post, 200);
    }
    
    /**
     * @OA\Get(
     *     path="/api/agenda",
     *     summary="Ambil daftar agenda",
     *     tags={"Agenda"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Cari berdasarkan judul atau isi",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil daftar agenda"
     *     )
     * )
     */
    public function getAgendaAll(Request $request)
    {
        $query = Agenda::query(); // Dapatkan Query Builder, bukan Collection

        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;

            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%')
                ->orWhere('agendacat', 'like', '%' . $keyword . '%');
            });
        }

        // Misal urutkan berdasarkan created_at terbaru
        $query->orderBy('created_at', 'desc');

        $posts = $query->paginate(10); // paginate ada di Query Builder

        return response()->json($posts, 200);
    }
    
    
    /**
     * @OA\Get(
     *     path="/api/agenda/{slug}",
     *     summary="Ambil detail agenda berdasarkan slug",
     *     tags={"Agenda"},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         description="Slug dari Agenda",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data agenda"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post tidak ditemukan"
     *     )
     * )
     */
    public function getAgendaSlug($slug)
    {
        $post = Agenda::where('slug', $slug)->first();
        
        return response()->json($post, 200);
    }
    
    /**
     * @OA\Get(
     *     path="/api/program",
     *     summary="Ambil daftar program",
     *     tags={"Program"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Cari berdasarkan name atau isi",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil daftar agenda"
     *     )
     * )
     */
    public function getProgramAll(Request $request)
    {
        $query = Program::query(); // Dapatkan Query Builder, bukan Collection
    
        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
    
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('description1', 'like', '%' . $keyword . '%');
            });
        }
    
        // Misal urutkan berdasarkan created_at terbaru
        $query->orderBy('created_at', 'desc');
    
        $programs = $query->paginate(10); // paginate ada di Query Builder
    
        return response()->json($programs, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/program/{slug}",
     *     summary="Ambil detail program berdasarkan slug",
     *     tags={"Program"},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         description="Slug dari Program",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data program"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Program tidak ditemukan"
     *     )
     * )
     */
    public function getProgramSlug($slug)
    {
        $program = Program::where('slug', $slug)->first();
        
        return response()->json($program, 200);
    }
    
    /**
     * @OA\Get(
     *     path="/api/unggulan",
     *     summary="Ambil daftar Unggulan",
     *     tags={"Unggulan"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Cari berdasarkan name atau isi",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil daftar Unggulan"
     *     )
     * )
     */
    public function getUnggulanAll(Request $request)
    {
        $query = Unggulan::query(); // Dapatkan Query Builder, bukan Collection
    
        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
    
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%')
                ->orWhere('description', 'like', '%' . $keyword . '%');
            });
        }
    
        // Misal urutkan berdasarkan created_at terbaru
        $query->orderBy('created_at', 'asc');
    
        $unggulans = $query->paginate(10); // paginate ada di Query Builder
    
        return response()->json($unggulans, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/unggulan/{slug}",
     *     summary="Ambil detail unggulan berdasarkan slug",
     *     tags={"Unggulan"},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         description="Slug dari unggulan",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data unggulan"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="unggulan tidak ditemukan"
     *     )
     * )
     */
    public function getUnggulanSlug($slug)
    {
        $unggulans = Unggulan::where('slug', $slug)->first();
        
        return response()->json($unggulans, 200);
    }
    
    /**
     * @OA\Get(
     *     path="/api/assesment",
     *     summary="Ambil daftar assesment",
     *     tags={"Assesment"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Cari berdasarkan name atau isi",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil daftar assesment"
     *     )
     * )
     */
    public function getAssesmentAll(Request $request)
    {
        $query = Facility::query(); // Dapatkan Query Builder, bukan Collection
    
        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
    
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%')
                ->orWhere('description', 'like', '%' . $keyword . '%');
            });
        }
    
        // Misal urutkan berdasarkan created_at terbaru
        $query->orderBy('created_at', 'desc');
    
        $assesment = $query->paginate(10); // paginate ada di Query Builder
    
        return response()->json($assesment, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/assesment/{slug}",
     *     summary="Ambil detail assesment berdasarkan slug",
     *     tags={"Assesment"},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         description="Slug dari assesment",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data assesment"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="assesment tidak ditemukan"
     *     )
     * )
     */
    public function getAssesmentSlug($slug)
    {
        $assements = Facility::where('slug', $slug)->first();
        
        return response()->json($assements, 200);
    }
    
    /**
     * @OA\Get(
     *     path="/api/pricing",
     *     summary="Ambil daftar pricing",
     *     tags={"Pricing"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Cari berdasarkan name atau isi dan harga",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil daftar pricing"
     *     )
     * )
     */
    public function getPricingAll(Request $request)
    {
        $query = Pricing::query(); // Dapatkan Query Builder, bukan Collection
    
        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
    
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%')
                ->orWhere('description', 'like', '%' . $keyword . '%')
                ->orWhere('price', 'like', '%' . $keyword . '%');
            });
        }
    
        // Misal urutkan berdasarkan created_at terbaru
        $query->orderBy('created_at', 'desc');
    
        $pricing = $query->paginate(10); // paginate ada di Query Builder
    
        return response()->json($pricing, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/pricing/{slug}",
     *     summary="Ambil detail pricing berdasarkan slug",
     *     tags={"Pricing"},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         description="Slug dari pricing",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data pricing"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="pricing tidak ditemukan"
     *     )
     * )
     */
    public function getPrcingSlug($slug)
    {
        $pricings = Pricing::where('slug', $slug)->first();
        
        return response()->json($pricings, 200);
    }
    
    /**
     * @OA\Get(
     *     path="/api/benefit",
     *     summary="Ambil daftar benefit",
     *     tags={"Benefit"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Cari berdasarkan title atau isi",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil daftar benefit"
     *     )
     * )
     */
    public function getBenefitAll(Request $request)
    {
        $query = Benefit::query(); // Dapatkan Query Builder, bukan Collection
    
        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
    
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%')
                ->orWhere('description', 'like', '%' . $keyword . '%');
            });
        }
    
        // Misal urutkan berdasarkan created_at terbaru
        $query->orderBy('created_at', 'desc');
    
        $benefits = $query->paginate(10); // paginate ada di Query Builder
    
        return response()->json($benefits, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/benefit/{slug}",
     *     summary="Ambil detail benefit berdasarkan slug",
     *     tags={"Benefit"},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         description="Slug dari benefit",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data benefit"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="benefit tidak ditemukan"
     *     )
     * )
     */
    public function getBenefitSlug($slug)
    {
        $benefits = Benefit::where('slug', $slug)->first();
        
        return response()->json($benefits, 200);
    }
    
    /**
     * @OA\Get(
     *     path="/api/benefit-assesment/{id}",
     *     summary="Ambil benefit berdasarkan Assesment (facility_id)",
     *     tags={"Benefit"},
     *     @OA\Parameter(
     *         name="id assesment (facility_id)",
     *         in="path",
     *         description="Id dari Assesment (facility_id)",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data benefit"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="benefit tidak ditemukan"
     *     )
     * )
     */
    public function getBenefitByAssesment($id)
    {
        $benefits = Benefit::where('facility_id', $id)->get();
        
        return response()->json($benefits, 200);
    }
    
    /**
     * @OA\Get(
     *     path="/api/testimoni",
     *     summary="Ambil daftar testimoni",
     *     tags={"Testimoni"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Cari berdasarkan name, title atau isi",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil daftar testimoni"
     *     )
     * )
     */
    public function getTestimoniAll(Request $request)
    {
        $query = Testimony::query(); // Dapatkan Query Builder, bukan Collection
    
        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
    
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%')
                ->orWhere('name', 'like', '%' . $keyword . '%')
                ->orWhere('description', 'like', '%' . $keyword . '%');
            });
        }
    
        // Misal urutkan berdasarkan created_at terbaru
        $query->orderBy('created_at', 'desc');
    
        $testimonis = $query->paginate(10); // paginate ada di Query Builder
    
        return response()->json($testimonis, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/testimoni/{slug}",
     *     summary="Ambil detail testimoni berdasarkan slug",
     *     tags={"Testimoni"},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         description="Slug dari testimoni",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data testimoni"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="testimoni tidak ditemukan"
     *     )
     * )
     */
    public function getTestimoniSlug($slug)
    {
        $testimonies = Testimony::where('slug', $slug)->first();
        
        return response()->json($testimonies, 200);
    }
    
    /**
     * @OA\Get(
     *     path="/api/portofolio",
     *     summary="Ambil daftar portofolio",
     *     tags={"Portofolio"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Cari berdasarkan title atau isi",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil daftar portofolio"
     *     )
     * )
     */
    public function getPortofolioAll(Request $request)
    {
        $query = Portofolio::query(); // Dapatkan Query Builder, bukan Collection
    
        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
    
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%')
                ->orWhere('description', 'like', '%' . $keyword . '%');
            });
        }
    
        // Misal urutkan berdasarkan created_at terbaru
        $query->orderBy('created_at', 'desc');
    
        $testimonis = $query->paginate(10); // paginate ada di Query Builder
    
        return response()->json($testimonis, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/portofolio/{slug}",
     *     summary="Ambil detail portofolio berdasarkan slug",
     *     tags={"Portofolio"},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         description="Slug dari portofolio",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data portofolio"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="portofolio tidak ditemukan"
     *     )
     * )
     */
    public function getPortofolioSlug($slug)
    {
        $testimonies = Portofolio::where('slug', $slug)->first();
        
        return response()->json($testimonies, 200);
    }
    
    /**
     * @OA\Get(
     *     path="/api/support",
     *     summary="Ambil daftar Support",
     *     tags={"Support"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Cari berdasarkan title atau name",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil daftar Support"
     *     )
     * )
     */
    public function getSupportAll(Request $request)
    {
        $query = Dukungan::query(); // Dapatkan Query Builder, bukan Collection
    
        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
    
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%')
                ->orWhere('name', 'like', '%' . $keyword . '%');
            });
        }
    
        // Misal urutkan berdasarkan created_at terbaru
        $query->orderBy('created_at', 'desc');
    
        $supports = $query->paginate(10); // paginate ada di Query Builder
    
        return response()->json($supports, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/support/{slug}",
     *     summary="Ambil detail Support berdasarkan slug",
     *     tags={"Support"},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         description="Slug dari Support",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data Support"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Support tidak ditemukan"
     *     )
     * )
     */
    public function getSupportSlug($slug)
    {
        $supports = Dukungan::where('slug', $slug)->first();
        
        return response()->json($supports, 200);
    }
    
    /**
     * @OA\Get(
     *     path="/api/partner",
     *     summary="Ambil daftar Partner",
     *     tags={"Partner"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Cari berdasarkan name atau isi",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil daftar Partner"
     *     )
     * )
     */
    public function getPartnerAll(Request $request)
    {
        // $query = Partner::query(); // Dapatkan Query Builder, bukan Collection
    
        // if ($request->has('search') && $request->search != '') {
        //     $keyword = $request->search;
    
        //     $query->where(function ($q) use ($keyword) {
        //         $q->where('name', 'like', '%' . $keyword . '%')
        //         ->orWhere('description', 'like', '%' . $keyword . '%');
        //     });
        // }
    
        // // Misal urutkan berdasarkan created_at terbaru
        // $query->orderBy('created_at', 'desc');
    
        // $partners = $query->paginate(50); // paginate ada di Query Builder

        $partners = Partner::all();
    
        return response()->json($partners, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/partner/{slug}",
     *     summary="Ambil detail Partner berdasarkan slug",
     *     tags={"Partner"},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         description="Slug dari Partner",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data Partner"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Partner tidak ditemukan"
     *     )
     * )
     */
    public function getPartnerSlug($slug)
    {
        $partners = Partner::where('slug', $slug)->first();
        
        return response()->json($partners, 200);
    }
    
    /**
     * @OA\Get(
     *     path="/api/legal",
     *     summary="Ambil daftar Legal",
     *     tags={"Legal"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Cari berdasarkan title atau isi",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil daftar Legal"
     *     )
     * )
     */
    public function getLegalAll(Request $request)
    {
        $query = Legal::query(); // Dapatkan Query Builder, bukan Collection
    
        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
    
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('description', 'like', '%' . $keyword . '%');
            });
        }
    
        // Misal urutkan berdasarkan created_at terbaru
        $query->orderBy('created_at', 'desc');
    
        $legals = $query->paginate(10); // paginate ada di Query Builder
    
        return response()->json($legals, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/legal/{id}",
     *     summary="Ambil detail Legal berdasarkan id",
     *     tags={"Legal"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id dari Legal",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data Legal"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Legal tidak ditemukan"
     *     )
     * )
     */
    public function getLegalId($id)
    {
        $legal = Legal::find($id);
        
        return response()->json($legal, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/team",
     *     summary="Ambil daftar Our Team",
     *     tags={"Ourteam"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Cari berdasarkan name atau title",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil daftar Our Team"
     *     )
     * )
     */
    public function getTeamAll(Request $request)
    {
        $query = Ourteam::query(); // Dapatkan Query Builder, bukan Collection
    
        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
    
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('description', 'like', '%' . $keyword . '%');
            });
        }
    
        // Misal urutkan berdasarkan created_at terbaru
        $query->orderBy('created_at', 'asc');
    
        $ourteams = $query->paginate(10); // paginate ada di Query Builder
    
        return response()->json($ourteams, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/team/{id}",
     *     summary="Ambil detail our team berdasarkan id",
     *     tags={"Ourteam"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id dari our team",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data our team"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="our team tidak ditemukan"
     *     )
     * )
     */
    public function getTeamId($id)
    {
        $team = Ourteam::find($id);
        
        return response()->json($team, 200);
    }
    
    /**
     * @OA\Get(
     *     path="/api/slider",
     *     summary="Ambil daftar Slider",
     *     tags={"Slider"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Cari berdasarkan title atau isi",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil daftar slider"
     *     )
     * )
     */
    public function getSliderAll(Request $request)
    {
        $query = Slider::query(); // Dapatkan Query Builder, bukan Collection
    
        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
    
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%')
                ->orWhere('description', 'like', '%' . $keyword . '%');
            });
        }
    
        // Misal urutkan berdasarkan created_at terbaru
        $query->orderBy('created_at', 'desc');
    
        $sliders = $query->paginate(10); // paginate ada di Query Builder
    
        return response()->json($sliders, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/meta-pixel",
     *     summary="Get the first Pixel setting",
     *     tags={"Pixel"},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *     )
     * )
     */
    public function indexPixel()
    {
        $pixels = Pixel::oldest()->take(1)->get();
        return response()->json($pixels, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/google-analytics",
     *     tags={"Google Analytics"},
     *     summary="Get the first Google Analytics setting",
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *     )
     * )
     */
    public function indexAnalytics()
    {
        $ganalytics = Ganalytics::oldest()->take(1)->get();
        return response()->json($ganalytics, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/chat",
     *     tags={"Welcome Chat"},
     *     summary="Get the first welcome chat message",
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *     )
     * )
     */
    public function indexChat()
    {
        $chat = Welcomechat::oldest()->take(1)->get();
        return response()->json($chat, 200);
    }
    
    /**
     * @OA\Get(
     *     path="/api/identity",
     *     tags={"Identitiy"},
     *     summary="Get the first Indentity",
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *     )
     * )
     */
    public function identitiy()
    {
        $identity = Identity::oldest()->take(1)->get();
        return response()->json($identity, 200);
    }

}