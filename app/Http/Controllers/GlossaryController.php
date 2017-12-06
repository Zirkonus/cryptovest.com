<?php

namespace App\Http\Controllers;

use App\GlossaryCategory;
use App\GlossaryItem;
use App\GlossaryWord;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;

class GlossaryController extends Controller
{
    /**
     * Return view list of categories
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listCategories()
    {
        $categories = GlossaryCategory::all();
        return view('admin.glossary.categories.index', ['categories' => $categories]);
    }

    /**
     * Return view create new category
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createCategory()
    {
        return view('admin.glossary.categories.create');
    }

    /**
     * Create new category and redirect to categories list
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function saveCategory(Request $request)
    {
        $rule = [
            'name' => 'unique:glossary_categories,name',
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        GlossaryCategory::create([
            'name' => $request->input('name'),
        ]);
        return redirect('admin/glossary/categories')->with('success', 'Category was created.');
    }

    /**
     * Return edit view with current category info
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editCategory($id)
    {
        $category = GlossaryCategory::find($id);
        return view('admin.glossary.categories.edit', ['category' => $category]);
    }

    /**
     * Update current category and redirect to category list
     *
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function updateCategory(Request $request, $id)
    {
        $category = GlossaryCategory::find($id);

        if ($category->name != $request->input('name')) {
            $rule = [
                'name' => 'unique:glossary_categories,name',
            ];
            $validator = Validator::make($request->all(), $rule);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $category->name = $request->input('name');
        }
        $category->save();
        return redirect('admin/glossary/categories')->with('success', 'Category was edited.');
    }

    public function deleteCategory($id)
    {
        GlossaryCategory::where('id', $id)->delete();
        return redirect('admin/glossary/categories')->with('success', 'Category was deleted.');
    }

    /**
     * Return view list of glossary items
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listItems()
    {
        $items = GlossaryItem::all();
        return view('admin.glossary.items.index', ['items' => $items]);
    }

    /**
     * Return view create new glossary item
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createItems()
    {
        $categories = GlossaryCategory::all()->pluck('name', 'id');
        return view('admin.glossary.items.create', ['categories' => $categories]);
    }

    /**
     * Create new Glossary item and redirect to items list
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function saveItems(Request $request)
    {
        $rule = [
            'title' => 'unique:glossary_items,title',
            'content' => 'required',
            'category' => 'required'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $item = GlossaryItem::create([
            'title' => $request->input('title'),
            'content' => $request->input('content')
        ]);
        $item->glossaryCategory()->sync($request->input('category'));
        $item->save();
        return redirect('admin/glossary/items')->with('success', 'Glossary item was created.');
    }

    /**
     * Return edit view with current glossary item info
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editItems($id)
    {
        $item = GlossaryItem::find($id);
        $category = isset(head($item->glossaryCategory)[0]) ? head($item->glossaryCategory)[0]->id : "";
        $categories = GlossaryCategory::all()->pluck('name', 'id');
        return view('admin.glossary.items.edit', [
            'item' => $item,
            'category' => $category,
            'categories' => $categories
        ]);
    }

    /**
     * Update current item and redirect to item list
     *
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function updateItems(Request $request, $id)
    {
        $item = GlossaryItem::find($id);
        $rule = [
            'title' => 'required',
            'content' => 'required',
            'category' => 'required'
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $item->title = $request->input('title');
        $item->content = $request->input('content');
        $item->glossaryCategory()->sync($request->input('category'));
        $item->save();
        return redirect('admin/glossary/items')->with('success', 'Glossary Item was edited.');
    }

    public function deleteItems($id)
    {
        GlossaryItem::where('id', $id)->delete();
        return redirect('admin/glossary/items')->with('success', 'Glossary Item was deleted.');
    }

    public function getItemByParams(Request $request)
    {
        $char = $request->input("char");
        $searchWord = $request->input("word");
        $category = $request->input("category");
        $searchInput = $char ?: $searchWord;
        if ($category) {
            $cat = GlossaryCategory::with([
                'glossaryItem'
                => function ($query) use ($searchInput) {
                    $query->where('title', 'LIKE', $searchInput . '%')
                        ->selectRaw('*, LEFT (title, 1) as first_char')
                        ->orderBy("title");
                }])->where('id', $category)->first();
            $collection = new Collection();
            if (isset($cat->glossaryItem)) {
                foreach ($cat->glossaryItem as $item) {
                    $item->category = $cat->name;
                    $collection->push($item);
                }
            }
        } else {
            $collection = GlossaryItem::where('title', 'LIKE', $searchInput . '%')
                ->selectRaw('*, LEFT (title, 1) as first_char')
                ->orderBy("title")
                ->get();
        }

        $paginate = $this->paginate($collection, 4, $request->input("page"));
        $result = [];
        foreach ($paginate as $item) {
            $firstLetter = strtoupper(substr($item->title, 0, 1));
            $innerItem = [];
            $innerItem["title"] = $item->title;
            $innerItem["content"] = $item->content;
            if ($category) {
                $innerItem["category"] = isset($item->category) ? $item->category : "";
            } else {
                $innerItem["category"] = head($item->glossaryCategory) ? $item->glossaryCategory->first()->name : "";
            }
            if (!isset($result[$firstLetter])) {
                $result[$firstLetter] = [$innerItem];
            } else {
                array_push($result[$firstLetter], $innerItem);
            }
        }
        return json_encode($result);
    }

    protected function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
