<footer class="main-footer">
    <?php
        $generalSettings = App\Models\Admin\Settings\GeneralSetting::first();
    ?>
    <strong>Copyright &copy; <script>document.write(new Date().getFullYear())</script>
        <a title="Compant Name" href="{{ isset($generalSettings) ? $generalSettings->website : ''}}">{{ isset($generalSettings) ? $generalSettings->name : ''}}</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      Email: <b>{{ isset($generalSettings) ? $generalSettings->email : ''}}, </b> Phone: <b>{{ isset($generalSettings) ? $generalSettings->phone : ''}}</b>
    </div>
  </footer>
