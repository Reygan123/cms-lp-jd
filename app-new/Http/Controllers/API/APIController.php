<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Agenda;
use App\Models\Alasanservice;
use App\Models\Program;
use App\Models\Unggulan;
use App\Models\Facility;
use App\Models\Pricing;
use App\Models\Benefit;
use App\Models\Bonusservice;
use App\Models\Testimony;
use App\Models\Portofolio;
use App\Models\Dukungan;
use App\Models\Faq;
use App\Models\Partner;
use App\Models\Legal;
use App\Models\Ourteam;
use App\Models\Slider;
use App\Models\Pixel;
use App\Models\Ganalytics;
use App\Models\Howservice;
use App\Models\Welcomechat;
use App\Models\Identity;
use App\Models\Manfaatservice;
use App\Models\Masalahservice;
use App\Models\Service;
use App\Models\Statistik;
use App\Models\Usp;
use App\Models\Whyservice;

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
        $query = Partner::query(); // Dapatkan Query Builder, bukan Collection

        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;

            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('description', 'like', '%' . $keyword . '%');
            });
        }

        // Misal urutkan berdasarkan created_at terbaru
        $query->orderBy('created_at', 'desc');

        $partners = $query->paginate(10); // paginate ada di Query Builder

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

    /**
     * @OA\Get(
     *     path="/api/service",
     *     summary="Get all services",
     *     tags={"Service"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search by service name",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of services",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="current_page", type="integer"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Service")
     *             ),
     *             @OA\Property(property="first_page_url", type="string"),
     *             @OA\Property(property="from", type="integer"),
     *             @OA\Property(property="last_page", type="integer"),
     *             @OA\Property(property="last_page_url", type="string"),
     *             @OA\Property(property="links", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="next_page_url", type="string"),
     *             @OA\Property(property="path", type="string"),
     *             @OA\Property(property="per_page", type="integer"),
     *             @OA\Property(property="prev_page_url", type="string"),
     *             @OA\Property(property="to", type="integer"),
     *             @OA\Property(property="total", type="integer")
     *         )
     *     )
     * )
     */
    public function getServiceAll(Request $request)
    {
        $query = Service::query();

        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;

            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('title1', 'like', '%' . $keyword . '%')
                    ->orWhere('title2', 'like', '%' . $keyword . '%');
            });
        }

        $services = $query->orderBy('created_at', 'desc')->paginate(10);

        // Transform the response to include full image URLs
        $services->getCollection()->transform(function ($service) {
            $service = $this->transformServiceImages($service);
            return $service;
        });

        return response()->json($services, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/service/{slug}",
     *     summary="Get service by slug",
     *     tags={"Service"},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         description="Service slug",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Service details",
     *         @OA\JsonContent(ref="#/components/schemas/Service")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Service not found"
     *     )
     * )
     */
    public function getServiceSlug($slug)
    {
        $service = Service::where('slug', $slug)->first();

        if (!$service) {
            return response()->json([
                'message' => 'Service not found'
            ], 404);
        }

        // Transform the response to include full image URLs
        $service = $this->transformServiceImages($service);

        return response()->json($service, 200);
    }

    /**
     * Transform service images to include full URLs
     */
    private function transformServiceImages($service)
    {
        for ($i = 1; $i <= 4; $i++) {
            $imageField = 'image' . $i;
            if ($service->$imageField) {
                $service->$imageField = asset('storage/services/' . $service->$imageField);
            }
        }
        return $service;
    }

    /**
     * @OA\Get(
     *     path="/api/why-service",
     *     summary="Get all why services",
     *     tags={"WhyService"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search by title",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of why services",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="current_page", type="integer"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/WhyService")
     *             ),
     *             @OA\Property(property="first_page_url", type="string"),
     *             @OA\Property(property="from", type="integer"),
     *             @OA\Property(property="last_page", type="integer"),
     *             @OA\Property(property="last_page_url", type="string"),
     *             @OA\Property(property="links", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="next_page_url", type="string"),
     *             @OA\Property(property="path", type="string"),
     *             @OA\Property(property="per_page", type="integer"),
     *             @OA\Property(property="prev_page_url", type="string"),
     *             @OA\Property(property="to", type="integer"),
     *             @OA\Property(property="total", type="integer")
     *         )
     *     )
     * )
     */
    public function getWhyServiceAll(Request $request)
    {
        $query = Whyservice::query()->with('service');

        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $whyServices = $query->latest()->paginate(10);

        // Transform the response to include full image URLs
        $whyServices->getCollection()->transform(function ($whyService) {
            return $this->transformWhyService($whyService);
        });

        return response()->json($whyServices, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/why-service/by-service-slug/{service_slug}",
     *     summary="Get why services by service slug",
     *     tags={"WhyService"},
     *     @OA\Parameter(
     *         name="service_slug",
     *         in="path",
     *         description="Slug of the service",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of why services for the specified service",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="current_page", type="integer"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/WhyService")
     *             ),
     *             @OA\Property(property="first_page_url", type="string"),
     *             @OA\Property(property="from", type="integer"),
     *             @OA\Property(property="last_page", type="integer"),
     *             @OA\Property(property="last_page_url", type="string"),
     *             @OA\Property(property="links", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="next_page_url", type="string"),
     *             @OA\Property(property="path", type="string"),
     *             @OA\Property(property="per_page", type="integer"),
     *             @OA\Property(property="prev_page_url", type="string"),
     *             @OA\Property(property="to", type="integer"),
     *             @OA\Property(property="total", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Service not found"
     *     )
     * )
     */
    public function getWhyServiceByServiceSlug($service_slug)
    {
        $service = Service::where('slug', $service_slug)->first();
        if (!$service) {
            return response()->json([
                'message' => 'Service not found'
            ], 404);
        }

        $whyServices = Whyservice::with('service')
            ->where('service_id', $service->id)
            ->latest()
            ->paginate(10);

        $whyServices->getCollection()->transform(function ($whyService) {
            return $this->transformWhyService($whyService);
        });

        return response()->json($whyServices, 200);
    }

    /**
     * Transform why service to include full image URL
     */
    private function transformWhyService($whyService)
    {
        if ($whyService->image) {
            $whyService->image = asset('storage/why-services/' . $whyService->image);
        }
        return $whyService;
    }

    /**
     * @OA\Get(
     *     path="/api/alasan-service",
     *     summary="Get all alasan services",
     *     tags={"AlasanService"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search by title",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of alasan services",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="current_page", type="integer"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/AlasanService")
     *             ),
     *             @OA\Property(property="first_page_url", type="string"),
     *             @OA\Property(property="from", type="integer"),
     *             @OA\Property(property="last_page", type="integer"),
     *             @OA\Property(property="last_page_url", type="string"),
     *             @OA\Property(property="links", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="next_page_url", type="string"),
     *             @OA\Property(property="path", type="string"),
     *             @OA\Property(property="per_page", type="integer"),
     *             @OA\Property(property="prev_page_url", type="string"),
     *             @OA\Property(property="to", type="integer"),
     *             @OA\Property(property="total", type="integer")
     *         )
     *     )
     * )
     */
    public function getAlasanServiceAll(Request $request)
    {
        $query = Alasanservice::query()->with('service');

        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $alasanServices = $query->latest()->paginate(10);

        // Transform the response to include full image URLs
        $alasanServices->getCollection()->transform(function ($alasanService) {
            return $this->transformAlasanService($alasanService);
        });

        return response()->json($alasanServices, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/alasan-service/by-service-slug/{service_slug}",
     *     summary="Get alasan services by service slug",
     *     tags={"AlasanService"},
     *     @OA\Parameter(
     *         name="service_slug",
     *         in="path",
     *         description="Slug of the service",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of alasan services",
     *         @OA\JsonContent(ref="#/components/schemas/PaginatedAlasanService")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Service not found"
     *     )
     * )
     */
    public function getAlasanServiceByServiceSlug($service_slug)
    {
        $service = Service::where('slug', $service_slug)->first();
        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        $alasanServices = AlasanService::with('service')
            ->where('service_id', $service->id)
            ->latest()
            ->paginate(10);

        $alasanServices->getCollection()->transform(function ($item) {
            return $this->transformAlasanService($item);
        });

        return response()->json($alasanServices, 200);
    }

    /**
     * Transform why service to include full image URL
     */
    private function transformAlasanService($alasanService)
    {
        if ($alasanService->image) {
            $alasanService->image = asset('storage/alasan-services/' . $alasanService->image);
        }
        return $alasanService;
    }

    /**
     * @OA\Get(
     *     path="/api/how-service",
     *     summary="Get all how services",
     *     tags={"HowService"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search by title",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of how services",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="current_page", type="integer"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/HowService")
     *             ),
     *             @OA\Property(property="first_page_url", type="string"),
     *             @OA\Property(property="from", type="integer"),
     *             @OA\Property(property="last_page", type="integer"),
     *             @OA\Property(property="last_page_url", type="string"),
     *             @OA\Property(property="links", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="next_page_url", type="string"),
     *             @OA\Property(property="path", type="string"),
     *             @OA\Property(property="per_page", type="integer"),
     *             @OA\Property(property="prev_page_url", type="string"),
     *             @OA\Property(property="to", type="integer"),
     *             @OA\Property(property="total", type="integer")
     *         )
     *     )
     * )
     */
    public function getHowServiceAll(Request $request)
    {
        $query = Whyservice::query()->with('service');

        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $howServices = $query->latest()->paginate(10);

        // Transform the response to include full image URLs
        $howServices->getCollection()->transform(function ($howService) {
            return $this->transformHowService($howService);
        });

        return response()->json($howServices, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/how-service/by-service-slug/{service_slug}",
     *     summary="Get how services by service slug",
     *     tags={"HowService"},
     *     @OA\Parameter(
     *         name="service_slug",
     *         in="path",
     *         description="Slug of the service",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of how services",
     *         @OA\JsonContent(ref="#/components/schemas/PaginatedHowService")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Service not found"
     *     )
     * )
     */
    public function getHowServiceByServiceSlug($service_slug)
    {
        $service = Service::where('slug', $service_slug)->first();
        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        $howServices = MasalahService::with('service')
            ->where('service_id', $service->id)
            ->latest()
            ->paginate(10);

        $howServices->getCollection()->transform(function ($item) {
            return $this->transformHowService($item);
        });

        return response()->json($howServices, 200);
    }

    /**
     * Transform how service to include full image URL
     */
    private function transformHowService($howService)
    {
        if ($howService->image) {
            $howService->image = asset('storage/how-services/' . $howService->image);
        }
        return $howService;
    }

    /**
     * @OA\Get(
     *     path="/api/bonus-service",
     *     summary="Get all bonus services",
     *     tags={"WhyService"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search by title",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of bonus services",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="current_page", type="integer"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/WhyService")
     *             ),
     *             @OA\Property(property="first_page_url", type="string"),
     *             @OA\Property(property="from", type="integer"),
     *             @OA\Property(property="last_page", type="integer"),
     *             @OA\Property(property="last_page_url", type="string"),
     *             @OA\Property(property="links", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="next_page_url", type="string"),
     *             @OA\Property(property="path", type="string"),
     *             @OA\Property(property="per_page", type="integer"),
     *             @OA\Property(property="prev_page_url", type="string"),
     *             @OA\Property(property="to", type="integer"),
     *             @OA\Property(property="total", type="integer")
     *         )
     *     )
     * )
     */
    public function getBonusServiceAll(Request $request)
    {
        $query = Whyservice::query()->with('service');

        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $whyServices = $query->latest()->paginate(10);

        // Transform the response to include full image URLs
        $whyServices->getCollection()->transform(function ($whyService) {
            return $this->transformBonusService($whyService);
        });

        return response()->json($whyServices, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/bonus-service/by-service-slug/{service_slug}",
     *     summary="Get bonus services by service slug",
     *     tags={"BonusService"},
     *     @OA\Parameter(
     *         name="service_slug",
     *         in="path",
     *         description="Slug of the service",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of bonus services",
     *         @OA\JsonContent(ref="#/components/schemas/PaginatedBonusService")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Service not found"
     *     )
     * )
     */
    public function getBonusServiceByServiceSlug($service_slug)
    {
        $service = Service::where('slug', $service_slug)->first();
        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        $bonusServices = BonusService::with('service')
            ->where('service_id', $service->id)
            ->latest()
            ->paginate(10);

        $bonusServices->getCollection()->transform(function ($item) {
            return $this->transformBonusService($item);
        });

        return response()->json($bonusServices, 200);
    }

    /**
     * Transform bonus service to include full image URL
     */
    private function transformBonusService($bonusService)
    {
        if ($bonusService->image) {
            $bonusService->image = asset('storage/bonus-services/' . $bonusService->image);
        }
        return $bonusService;
    }

    // MasalahService API
    /**
     * @OA\Get(
     *     path="/api/masalah-service",
     *     summary="Get all masalah services",
     *     tags={"MasalahService"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search by title",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of masalah services",
     *         @OA\JsonContent(ref="#/components/schemas/PaginatedMasalahService")
     *     )
     * )
     */
    public function getMasalahServiceAll(Request $request)
    {
        $query = Masalahservice::query()->with('service');

        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $masalahServices = $query->latest()->paginate(10);
        $masalahServices->getCollection()->transform(function ($item) {
            return $this->transformMasalahService($item);
        });

        return response()->json($masalahServices, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/masalah-service/by-service-slug/{service_slug}",
     *     summary="Get masalah services by service slug",
     *     tags={"MasalahService"},
     *     @OA\Parameter(
     *         name="service_slug",
     *         in="path",
     *         description="Slug of the service",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of masalah services",
     *         @OA\JsonContent(ref="#/components/schemas/PaginatedMasalahService")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Service not found"
     *     )
     * )
     */
    public function getMasalahServiceByServiceSlug($service_slug)
    {
        $service = Service::where('slug', $service_slug)->first();
        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        $masalahServices = MasalahService::with('service')
            ->where('service_id', $service->id)
            ->latest()
            ->paginate(10);

        $masalahServices->getCollection()->transform(function ($item) {
            return $this->transformMasalahService($item);
        });

        return response()->json($masalahServices, 200);
    }

    private function transformMasalahService($masalahService)
    {
        if ($masalahService->image) {
            $masalahService->image = asset('storage/masalah-services/' . $masalahService->image);
        }
        return $masalahService;
    }

    // Activity API
    /**
     * @OA\Get(
     *     path="/api/activity",
     *     summary="Get all activities",
     *     tags={"Activity"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search by title",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of activities",
     *         @OA\JsonContent(ref="#/components/schemas/PaginatedActivity")
     *     )
     * )
     */
    public function getActivityAll(Request $request)
    {
        $query = Activity::query()->with('service');

        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $activities = $query->latest()->paginate(10);
        $activities->getCollection()->transform(function ($item) {
            return $this->transformActivity($item);
        });

        return response()->json($activities, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/activity/by-service-slug/{service_slug}",
     *     summary="Get activities by service slug",
     *     tags={"Activity"},
     *     @OA\Parameter(
     *         name="service_slug",
     *         in="path",
     *         description="Slug of the service",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of activities",
     *         @OA\JsonContent(ref="#/components/schemas/PaginatedActivity")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Service not found"
     *     )
     * )
     */
    public function getActivityByServiceSlug($service_slug)
    {
        $service = Service::where('slug', $service_slug)->first();
        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        $activities = Activity::with('service')
            ->where('service_id', $service->id)
            ->latest()
            ->paginate(10);

        $activities->getCollection()->transform(function ($item) {
            return $this->transformActivity($item);
        });

        return response()->json($activities, 200);
    }

    private function transformActivity($activity)
    {
        if ($activity->image) {
            $activity->image = asset('storage/activities/' . $activity->image);
        }
        return $activity;
    }

    // ManfaatService API
    /**
     * @OA\Get(
     *     path="/api/manfaat-service",
     *     summary="Get all manfaat services",
     *     tags={"ManfaatService"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search by title",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of manfaat services",
     *         @OA\JsonContent(ref="#/components/schemas/PaginatedManfaatService")
     *     )
     * )
     */
    public function getManfaatServiceAll(Request $request)
    {
        $query = Manfaatservice::query()->with('service');

        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $manfaatServices = $query->latest()->paginate(10);
        $manfaatServices->getCollection()->transform(function ($item) {
            return $this->transformManfaatService($item);
        });

        return response()->json($manfaatServices, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/manfaat-service/by-service-slug/{service_slug}",
     *     summary="Get manfaat services by service slug",
     *     tags={"ManfaatService"},
     *     @OA\Parameter(
     *         name="service_slug",
     *         in="path",
     *         description="Slug of the service",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of manfaat services",
     *         @OA\JsonContent(ref="#/components/schemas/PaginatedManfaatService")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Service not found"
     *     )
     * )
     */
    public function getManfaatServiceByServiceSlug($service_slug)
    {
        $service = Service::where('slug', $service_slug)->first();
        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        $manfaatServices = ManfaatService::with('service')
            ->where('service_id', $service->id)
            ->latest()
            ->paginate(10);

        $manfaatServices->getCollection()->transform(function ($item) {
            return $this->transformManfaatService($item);
        });

        return response()->json($manfaatServices, 200);
    }

    private function transformManfaatService($manfaatService)
    {
        if ($manfaatService->image) {
            $manfaatService->image = asset('storage/manfaat-services/' . $manfaatService->image);
        }
        return $manfaatService;
    }

    // Statistik API
    /**
     * @OA\Get(
     *     path="/api/statistik",
     *     summary="Get all statistics data",
     *     tags={"Statistik"},
     *     @OA\Response(
     *         response=200,
     *         description="List of statistics",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="current_page", type="integer"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Statistik")
     *             ),
     *             @OA\Property(property="first_page_url", type="string"),
     *             @OA\Property(property="from", type="integer"),
     *             @OA\Property(property="last_page", type="integer"),
     *             @OA\Property(property="last_page_url", type="string"),
     *             @OA\Property(property="links", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="next_page_url", type="string"),
     *             @OA\Property(property="path", type="string"),
     *             @OA\Property(property="per_page", type="integer"),
     *             @OA\Property(property="prev_page_url", type="string"),
     *             @OA\Property(property="to", type="integer"),
     *             @OA\Property(property="total", type="integer")
     *         )
     *     )
     * )
     */
    public function getStatistikAll()
    {
        $statistiks = Statistik::latest()->paginate(10);
        return response()->json($statistiks, 200);
    }

    // FAQ API
    /**
     * @OA\Get(
     *     path="/api/faq",
     *     summary="Get all FAQs",
     *     tags={"FAQ"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search by title",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of FAQs",
     *         @OA\JsonContent(ref="#/components/schemas/PaginatedFAQ")
     *     )
     * )
     */
    public function getFaqAll(Request $request)
    {
        $query = Faq::query();

        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $faqs = $query->oldest()->paginate(15);
        return response()->json($faqs, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/faq/by-category/{category}",
     *     summary="Get FAQs by category",
     *     tags={"FAQ"},
     *     @OA\Parameter(
     *         name="category",
     *         in="path",
     *         description="Category of FAQ",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search by title",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of FAQs by category",
     *         @OA\JsonContent(ref="#/components/schemas/PaginatedFAQ")
     *     )
     * )
     */
    public function getFaqByCategory(Request $request, $category)
    {
        $query = Faq::where('category', $category);

        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $faqs = $query->oldest()->paginate(15);
        return response()->json($faqs, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/usp",
     *     summary="Ambil daftar USP",
     *     tags={"USP"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Cari berdasarkan title atau description",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil daftar USP",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="current_page", type="integer"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/USP")
     *             ),
     *             @OA\Property(property="first_page_url", type="string"),
     *             @OA\Property(property="from", type="integer"),
     *             @OA\Property(property="last_page", type="integer"),
     *             @OA\Property(property="last_page_url", type="string"),
     *             @OA\Property(property="links", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="next_page_url", type="string"),
     *             @OA\Property(property="path", type="string"),
     *             @OA\Property(property="per_page", type="integer"),
     *             @OA\Property(property="prev_page_url", type="string"),
     *             @OA\Property(property="to", type="integer"),
     *             @OA\Property(property="total", type="integer")
     *         )
     *     )
     * )
     */
    public function getUspAll(Request $request)
    {
        $query = Usp::query();

        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $usps = $query->latest()->paginate(10);

        // Transform the response to include full image URLs
        $usps->getCollection()->transform(function ($usp) {
            if ($usp->image) {
                $usp->image = asset('storage/usps/' . $usp->image);
            }
            return $usp;
        });

        return response()->json($usps, 200);
    }
}
