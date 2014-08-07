<?php
$rootDir = __DIR__ . '/../../';
require_once $rootDir . 'core/fundControlApp.php';
/* @var $FundControl FundControl */
?>
<div class="scrollable">
  <div class="scrollable-content">
    <div class="section container-fluid">

      <ul class="nav nav-tabs">
        <li><a href="#Tab1" toggle="on" parent-active-class="active">Tab 1</a></li>
        <li><a href="#Tab2" toggle="on" parent-active-class="active">Tab 2</a></li>
        <li><a href="#Tab3" toggle="on" parent-active-class="active">Tab 3</a></li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane"
            toggleable
            active-class="active"
            default="active"
            id="Tab1"
            exclusion-group="myTabs">

          <h3 class="page-header">Tab 1</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi, commodi, corporis, dicta cupiditate officiis nostrum recusandae aperiam quia dolores amet architecto laudantium alias in omnis perferendis. Ullam asperiores dolorum nobis.</p>
        </div>

        <div class="tab-pane"
            toggleable
            active-class="active"
            id="Tab2"
            exclusion-group="myTabs">
          <h3 class="page-header">Tab 2</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet, esse minima magni asperiores optio exercitationem assumenda molestiae libero incidunt perferendis veniam quod. Nihil, rerum, nisi quo eos laborum libero expedita.</p>
        </div>

        <div class="tab-pane"
            toggleable
            active-class="active"
            id="Tab3"
            exclusion-group="myTabs">
          <h3 class="page-header">Tab 3</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis, pariatur, sint ab assumenda est dolor molestiae maxime eaque sequi adipisci corporis molestias quos officiis rerum accusantium illo ullam commodi blanditiis.</p>
        </div>
      </div>

      <div class="btn-group justified nav-tabs">
        <a class="btn btn-default"
           href="#Tab1"
           toggle="on"
           active-class="active">Tab 1
        </a>

        <a class="btn btn-default"
           href="#Tab2"
           toggle="on"
           active-class="active">Tab 2
        </a>

        <a class="btn btn-default"
           href="#Tab3"
           toggle="on"
           active-class="active">Tab 3
        </a>

      </div>

    </div>
  </div>
</div>