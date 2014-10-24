    <div>
      <div class="side-nav">

          <nav>
            <ul class="nav nav-pills nav-stacked">
              <li class="active">
                <?php echo $this->Html->link(__('ダッシュボード'),'/',array());?>
              </li>
              <li>
                <?php echo $this->Html->link(__('ユーザー'),'/users/',array());?>
              </li>
              <li>
                <?php echo $this->Html->link(__('権限'),'/roles/',array());?>
              </li>
            </ul>
          </nav>
        </div>
    </div>