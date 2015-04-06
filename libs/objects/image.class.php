<?

class Image {
	
	private $path = null; 
	private $thumb = null; 
	private $source = null;
	private $size = null;
	
	public $interlace = true;
	
	public function __construct () {}

    /**
     * @param $path
     * @throws Exception
     */
	public function load ($path) {
		
		$this -> path = $path;
		$this -> imageInfo ();
		$this -> readImage ();
		
	}

    /**
     * @param $w
     * @param $h
     */
	public function resize ($w, $h) {
		
		try {

			$this -> createThumb ($w, $h);
			
			imagecopyresampled($this -> thumb, $this -> source, 0, 0, 0, 0, $w, $h, $this -> size[0], $this -> size[1]);
			
			$this -> source = $this -> thumb;
			
		} catch (Exception $e) {
		
			echo $e->getMessage();
			
		}

	}

    /**
     * @param $w
     * @param $h
     * @param $x
     * @param $y
     */
	public function crop ($w, $h, $x, $y) {
		
		$this -> createThumb ($w, $h);
			
		imagecopyresampled($this -> thumb, $this -> source, 0, 0, $x, $y, $w, $h, $w, $h);
		
		$this -> source = $this -> thumb;
		
	}

    /**
     * @param $name
     */
	public function save ($name) {
		
		if ( $this -> interlace )
			imageinterlace($this -> source, true);
		
		imagejpeg($this -> source, $name, 100);
		imagedestroy($this -> source);
		
	}

    /**
     * @return mixed
     */
	public function getImageWidth () {
		
		$this -> imageInfo ();
		return $this -> size[0];
		
	}

    /**
     * @return mixed
     */
	public function getImageHeight () {
		
		$this -> imageInfo ();
		return $this -> size[1];
		
	}

    /**
     * @param $w
     * @param $h
     */
	private function createThumb ($w, $h){
		
		$this -> thumb = imagecreatetruecolor($w, $h);
		
	}

    /**
     * @throws Exception
     */
	private function readImage () {
		
		$type = exif_imagetype ($this -> path);
		
		switch ( $type ) {
			
			case "2":
				
				$this -> source = imagecreatefromjpeg($this -> path);
				
				break;
				
			case "3":
				
				$this -> source = imagecreatefrompng($this -> path);
				
				break;
			
		}
		
		
		
		if ( !$this -> source ) {
			
			throw new Exception('Не удалось считать файл');
			
		}
		
	}

    /**
     *
     */
	private function imageInfo () {

		$this -> size = getimagesize ($this -> path);

	}
	
	

}