<?php

namespace App\Http\Livewire\Settings;


class Page extends BaseSettingsComponent
{

    //
    public $driverDocumentInstructions;
    public $vendorDocumentInstructions;



    public function mount()
    {
        $this->pageSettings();
    }


    public function render()
    {
        return view('livewire.settings.page');
    }



    //
    //PAGE SETTINGS
    public function pageSettings()
    {
        $this->driverDocumentInstructions = setting('page.settings.driverDocumentInstructions', "");
        $this->vendorDocumentInstructions = setting('page.settings.vendorDocumentInstructions', "");
        $this->showPageSetting = true;
    }

    public function savePageSettings()
    {

        try {

            $this->isDemo();

            setting([
                'page.settings.driverDocumentInstructions' =>  $this->driverDocumentInstructions,
                'page.settings.vendorDocumentInstructions' =>  $this->vendorDocumentInstructions,
            ])->save();

            $this->showSuccessAlert(__("Page Settings saved successfully!"));
            $this->reset();
        } catch (Exception $error) {
            $this->showErrorAlert($error->getMessage() ?? __("Page Settings save failed!"));
        }
    }
}
