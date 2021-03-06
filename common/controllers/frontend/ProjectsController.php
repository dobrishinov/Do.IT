<?php

class ProjectsController extends Controller
{
    public function index()
    {
        $viewData = array();

        $search = (isset($_GET['search'])) ? htmlspecialchars(trim($_GET['search'])) : '';
        $page = (isset($_GET['page']) && (int)$_GET['page'] > 0)? (int)$_GET['page'] : 1;

        $projectsNumberPerPage = 8;
        $offset = ($page-1)*8;

        $projectsCollection = new ProjectsCollection();
        $projects = $projectsCollection->get(array(), $offset, $projectsNumberPerPage, $search, array('date', 'DESC'), 'title');

        $categoriesCollection = new CategoriesCollection();
        $categories = $categoriesCollection->get(1, null, null, null, null, null);

        $totalRows = count($projectsCollection->get(array(), null, null, $search, null, 'title'));
        $totalRows = ($totalRows == 0)? 1 : $totalRows;
        
        $paginator = new Pagination();
        $paginator->setPerPage($projectsNumberPerPage);
        $paginator->setTotalRows($totalRows);
        $paginator->setBaseUrl("index.php?c=projects&search={$search}");

        $viewData['projects'] = $projects;
        $viewData['categories'] = $categories;
        $viewData['paginator'] = $paginator;

        $this->loadFrontView('projects/list.php', $viewData);
    }

    public function show()
    {
        $viewData = array();

        if (!isset($_GET['id'])) {
            header('Location: index.php');
            exit;
        }

        $id = (int)($_GET['id']);

        $projectsCollection = new ProjectsCollection();
        $project = $projectsCollection->getOne($id);

        if ($project == null) {
            header('Location: index.php');
            exit;
        }

        $viewData['project'] = $project;

        $this->loadFrontView('projects/show.php', $viewData);
    }

    public function projectsByCategory()
    {
        $viewData = array();

        $categoryId = (isset($_GET['categoryId']))? (int)$_GET['categoryId'] : 0;

        $categoriesCollection = new CategoriesCollection();
        $categories = $categoriesCollection->get(1, null, null, null, null, null);

        $projectsCollection = new ProjectsCollection();

        $where = array();
        if ($categoryId != 0) {
            $where = array(
                'category_id' => $categoryId
            );
        }


        //В тази променлива пазим броя резултати които искаме да върне заявката
        $pageResults = 8;

        //В променливата $page присвояваме гет параметъра, който се придава. Ако няма гет параметър то тогава слагаме 1.
        $page = (isset($_GET['page']) && (int)$_GET['page'] > 0)? (int)$_GET['page'] : 1;

        //В тази променлива изчисляваме от кой точно резултат да започне броенето в заявката.
        $offset = ($page-1)*$pageResults;

        $projects = $projectsCollection->get($where, $offset, $pageResults, null, array('date', 'DESC'), 'name');

        $totalRows = count($projectsCollection->get(array(), -1, 0, null, array('date', 'DESC'), 'name'));
        $totalRows = ($totalRows == 0)? 1 : $totalRows;

        $paginator = new Pagination();
        $paginator->setPerPage($pageResults);
        $paginator->setTotalRows($totalRows);
        $paginator->setBaseUrl('index.php?c=projects&m=projectsByCategory&categoryId='.$categoryId);

        $viewData['paginator'] = $paginator;
        $viewData['projects'] = $projects;
        $viewData['categories'] = $categories;

        $this->loadFrontView('projects/list.php', $viewData);
    }
}