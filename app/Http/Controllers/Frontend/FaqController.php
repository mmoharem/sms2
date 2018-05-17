<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Faq;
use App\Models\FaqCategory;

class FaqController extends FrontendController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $faq_categories = FaqCategory::where('role_id', 0)->get();
        $faqs = Faq::join('faq_categories', 'faq_categories.id','=','faqs.faq_category_id')
                        ->whereNull('faq_categories.deleted_at')
                        ->where('faq_categories.role_id',0)
                        ->distinct()
                        ->select('faqs.*')->get();
        $title = trans('frontend.faq');

        return view('faq', compact('faqs','faq_categories','title'));
    }
}
