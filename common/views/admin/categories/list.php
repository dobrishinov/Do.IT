<?php require_once __DIR__.'/../../../../admin/common/header.php' ?>
<?php require_once __DIR__.'/../../../../admin/common/sidebar.php' ?>

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Categories</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="index.php">Admin</a>
                </li>
                <li class="active">
                    <strong>Categories</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInDown">

            <?php if (isset($_SESSION['message'])): ?>

                <?php if (isset($_SESSION['message']['success'])): ?>
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Success: </strong> <?php echo $_SESSION['message']['success']; ?>
                    </div>
                    <?php unset($_SESSION['message']['success']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['message']['warning'])): ?>
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>OOPS!</strong> <?php echo $_SESSION['message']['warning'];?>
                    </div>
                    <?php unset($_SESSION['message']['warning']); ?>
                <?php endif; ?>

            <?php endif; ?>

            <div class="ibox">
                <div class="ibox-title">

                    <form action="" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="hidden" name="c" value="categories">
                                    <input type="text" class="form-control" name="search" value="<?php echo $search; ?>" placeholder="Search Categories">
                                    <span class="input-group-btn">
                                       <input type="submit" class="btn btn-primary" value="Go">
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <select class="form-control" name="orderBy" id="orderBy">
                                    <option value="1" <?php echo ($orderBy == 1)? 'selected': ''; ?>>Newest</option>
                                    <option value="2" <?php echo ($orderBy == 2)? 'selected': ''; ?>>Older</option>
                                    <option value="3" <?php echo ($orderBy == 3)? 'selected': ''; ?>>Username ascending</option>
                                    <option value="4" <?php echo ($orderBy == 4)? 'selected': ''; ?>>Username descending</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <select class="form-control" name="perPage" id="perPage">
                                    <option value="1" <?php echo  ($pageResults == 1)? 'selected' : ''; ?>>1</option>
                                    <option value="5" <?php echo  ($pageResults == 5)? 'selected' : ''; ?>>5</option>
                                    <option value="10" <?php echo  ($pageResults == 10)? 'selected' : ''; ?>>10</option>
                                </select>
                            </div>

                            <div class="col-md-2 col-md-offset-1">
                                <a href="index.php?c=categories&m=insert" class="btn btn-primary btn">New Category</a>
                            </div>

                        </div>

                    </form>

                    <br>

                </div>

                <div class="ibox-content table-responsive">
                    
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($categories as $category) { ?>
                            <tr>
                                <td class="col-md-5"><?php echo $category->getName(); ?></td>
                                <td class="col-md-5"><?php echo $category->getDescription(); ?></td>
                                <td class="col-md-2">
                                    <a href="index.php?c=categories&m=update&id=<?php echo $category->getId();?>" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>
                                    <a href="index.php?c=categories&m=delete&id=<?php echo $category->getId();?>" class="btn btn-white btn-sm"><i class="fa fa-trash"></i> Delete </a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>

                    <div class="text-center">
                        <?php echo $paginator->create(); ?>
                    </div>

                </div>
            </div>
    </div>

<?php require_once __DIR__.'/../../../../admin/common/footer.php' ?>