<?php
namespace ProcessWire;

class AlpineJSConfig extends ModuleConfig
{
    public function __construct()
    {
        $this->add([
            'activePlugins' => [],
            'installedVersion' => '0.0.0', // Tracks the local file version
            'custom_file' => '',
        ]);
    }

    public function getInputfields()
    {
        $inputfields = $this->wire(new InputfieldWrapper());
        $modules = $this->wire('modules');
        $session = $this->wire('session');
        $input = $this->wire('input');

        // Handle Update Action (POST request with specific button name)
        if ($input->requestMethod('POST') && $input->post->download_alpine_now) {
            $module = $modules->get('AlpineJS');
            $latest = AlpineJS::getRemoteVersion();
            if ($latest) {
                if ($module->downloadAlpineFiles($latest)) {
                    $this->installedVersion = $latest; // Update config object
                    $modules->saveConfig('AlpineJS', ['installedVersion' => $latest]); // Persist
                    $session->message(__("Successfully updated AlpineJS files to version $latest"));
                    $session->redirect('./'); // Redirect to clear POST
                }
            }
        }

        // --- Update / Version Section ---
        $fs = $modules->get('InputfieldFieldset');
        $fs->label = __('Update & Version Management');
        $fs->icon = 'cloud-download';

        $currentVer = $this->installedVersion;
        $remoteVer = AlpineJS::getRemoteVersion() ?: __('Unknown (Offline?)');

        $statusLabel = "Current: <b>$currentVer</b> | Latest Available: <b>$remoteVer</b>";
        $btnLabel = __('Re-Download Files');
        $btnIcon = 'refresh';
        $btnClass = 'ui-priority-secondary';

        if ($currentVer !== $remoteVer && $remoteVer !== 'Unknown (Offline?)') {
            $statusLabel .= " <span style='color: white; background: #e53e3e; padding: 2px 6px; border-radius: 4px; margin-left: 10px;'>" . __('Update Available!') . "</span>";
            $btnLabel = __('Update to ') . $remoteVer;
            $btnIcon = 'cloud-download';
            $btnClass = 'ui-priority-primary';
        }

        $f = $modules->get('InputfieldMarkup');
        $f->label = __('Version Status');
        $f->value = "<div style='font-size: 1.1em; margin-bottom: 10px;'>$statusLabel</div>";
        $fs->add($f);

        $f = $modules->get('InputfieldSubmit');
        $f->attr('name', 'download_alpine_now');
        $f->attr('value', $btnLabel);
        $f->icon = $btnIcon;
        $f->attr('class', $btnClass . ' ui-button');
        $f->description = __('Clicking this will download the Core and all Plugins from unpkg.com and save them to /site/modules/AlpineJS/js/.');
        $fs->add($f);

        $inputfields->add($fs);

        // --- Configuration Section ---
        $fs = $modules->get('InputfieldFieldset');
        $fs->label = __('Settings');
        $fs->icon = 'sliders';

        $f = $modules->get('InputfieldText');
        $f->attr('name', 'custom_file');
        $f->label = __('Custom Alpine.js file path');
        $f->description = __('Path to an Alpine.js file relative to the site root. When set, the downloaded version above is ignored.');
        $f->attr('value', $this->custom_file);
        $f->collapsed = $this->custom_file ? Inputfield::collapsedNo : Inputfield::collapsedBlank;
        $fs->add($f);

        $f = $modules->get('InputfieldCheckboxes');
        $f->attr('name', 'activePlugins');
        $f->label = __('Active Plugins');
        $f->description = __('Select which plugins to load (must be downloaded first via the button above).');
        $f->icon = 'puzzle-piece';

        $pluginLabels = [
            'mask' => __('Mask - Input masking'),
            'intersect' => __('Intersect - Visibility observation'),
            'persist' => __('Persist - Persist data in localStorage'),
            'focus' => __('Focus - Focus management (trap)'),
            'collapse' => __('Collapse - Smooth toggle transitions'),
            'morph' => __('Morph - Smooth DOM diffing/morphing'),
            'history' => __('History - Query string synchronization'),
        ];

        foreach ($pluginLabels as $key => $label) {
            $f->addOption($key, $label);
        }

        $f->attr('value', $this->activePlugins);
        $f->columnWidth = 100;
        $fs->add($f);

        $inputfields->add($fs);

        return $inputfields;
    }
}
