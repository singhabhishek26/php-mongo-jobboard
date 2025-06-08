<?php include("partials/header.php"); ?>
<?php include("partials/loader.php"); ?>


<div class="site-wrap">

    <div class="site-mobile-menu site-navbar-target">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close mt-3">
                <span class="icon-close2 js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
    </div> <!-- .site-mobile-menu -->

    <!-- NAVBAR -->
    <?php include("partials/navbar.php"); ?>


    <!-- HOME -->
    <section class="section-hero overlay inner-page bg-image" style="background-image: url('images/hero_1.jpg');"
        id="home-section">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <h1 class="text-white font-weight-bold">Post A Job</h1>
                    <div class="custom-breadcrumbs">
                        <a href="#">Home</a> <span class="mx-2 slash">/</span>
                        <a href="#">Job</a> <span class="mx-2 slash">/</span>
                        <span class="text-white"><strong>Post a Job</strong></span>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="site-section">
        <div class="container">

            <div class="row align-items-center mb-5">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2>Post A Job</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-lg-12">
                    <form class="p-4 p-md-5 border rounded" method="post" action="insert_job.php"
                        enctype="multipart/form-data">
                        <h3 class="text-black mb-5 border-bottom pb-2">Job Details</h3>

                        <div class="form-group">
                            <label for="company-website-tw d-block">Upload Logo</label> <br>
                            <label class="btn btn-primary btn-md btn-file">
                                Browse File<input type="file" name="company_logo" hidden>
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" id="email"
                                placeholder="you@yourdomain.com">
                        </div>
                        <div class="form-group">
                            <label for="job-title">Job Title</label>
                            <input type="text" class="form-control" name="job-title" id="job-title"
                                placeholder="Product Designer">
                        </div>
                        <div class="form-group">
                            <label for="job-location">Location</label>
                            <input type="text" class="form-control" name="job-location" id="job-location"
                                placeholder="e.g. New York">
                        </div>

                        <div class="form-group">
                            <label for="job-region">Job Region</label>
                            <select class="selectpicker border rounded" name="job-region" id="job-region"
                                data-style="btn-black" data-width="100%" data-live-search="true" title="Select Region">
                                <option value="Anywhere">Anywhere</option>
                                <option value="San Francisco">San Francisco</option>
                                <option value="Palo Alto">Palo Alto</option>
                                <option value="New York">New York</option>
                                <option value="Manhattan">Manhattan</option>
                                <option value="Ontario">Ontario</option>
                                <option value="Toronto">Toronto</option>
                                <option value="Kansas">Kansas</option>
                                <option value="Mountain View">Mountain View</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="job-type">Job Type</label>
                            <select class="selectpicker border rounded" name="job-type" id="job-type"
                                data-style="btn-black" data-width="100%" data-live-search="true"
                                title="Select Job Type">
                                <option value="Part Time">Part Time</option>
                                <option value="Full Time">Full Time</option>
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="job-description">Job Description</label>
                            <div class="editor" id="editor-1">
                                <p>Write Job Description!</p>
                            </div>
                            <input type="hidden" name="job_description" id="job_description_input">
                        </div>


                        <h3 class="text-black my-5 border-bottom pb-2">Company Details</h3>
                        <div class="form-group">
                            <label for="company-name">Company Name</label>
                            <input type="text" class="form-control" name="company-name" id="company-name"
                                placeholder="e.g. New York">
                        </div>

                        <div class="form-group">
                            <label for="company-tagline">Tagline (Optional)</label>
                            <input type="text" class="form-control" name="company-tagline" id="company-tagline"
                                placeholder="e.g. New York">
                        </div>

                        <div class="form-group">
                            <label for="job-description">Company Description (Optional)</label>
                            <div class="editor" id="editor-2">
                                <p>Description</p>
                            </div>
                            <input type="hidden" name="company_description" id="company_description_input">
                        </div>

                        <div class="form-group">
                            <label for="company-website">Website (Optional)</label>
                            <input type="text" class="form-control" name="company-website" id="company-website"
                                placeholder="https://">
                        </div>

                        <div class="form-group">
                            <label for="company-website-fb">Facebook Username (Optional)</label>
                            <input type="text" class="form-control" name="company-website-fb" id="company-website-fb"
                                placeholder="companyname">
                        </div>

                        <div class="form-group">
                            <label for="company-website-tw">Twitter Username (Optional)</label>
                            <input type="text" class="form-control" name="company-website-tw" id="company-website-tw"
                                placeholder="@companyname">
                        </div>
                        <div class="form-group">
                            <label for="company-website-tw">Linkedin Username (Optional)</label>
                            <input type="text" class="form-control" name="company-website-li" id="company-website-tw"
                                placeholder="companyname">
                        </div>

                    </form>
                </div>


            </div>
            <div class="row align-items-center mb-5">

                <div class="col-lg-4 ml-auto">
                    <div class="row">
                        <div class="col-6">
                            <a href="#" class="btn btn-block btn-primary btn-md">Save Job</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <?php include("partials/footer.php"); ?>