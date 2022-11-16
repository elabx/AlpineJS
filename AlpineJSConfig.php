<?php namespace ProcessWire;
class AlpineJSConfig extends ModuleConfig {
		public function getInputfields() {
				$class = rtrim($this->className(), 'Config');
				$config = $this->config;
				$inputfields = $this->wire(new InputfieldWrapper());
				$f = $this->wire('modules')->get('InputfieldRadios');
				$f->attr('name', 'version');
				$f->attr('label', 'Version');
				$files = $this->files;
				$versions = $files->find("{$config->paths->$class}alpinejs", [
					'allowDirs' => true,
					'recursive' => false,
					'returnRelative'=> true
				]);
				foreach($versions as $i => $version){
						$version = rtrim($version,"/");
						$versions[$i] = $version;
						$f->addOption(rtrim($version,"/"));
				}
				$f->attr('value', isset($data['version']) ? $data['version'] : $versions[0]);
				$inputfields->add($f);
				return $inputfields;
		}
}
