<?php

namespace Ranosys\Rma\Model;

class Pdf {
    
    protected $fileFactory;
    
    protected $directoryList;
    
    protected $pageNumber;
    
    protected $font;
    
    protected $fontBold;
    
    protected $y = 850;
    
    protected $x = 30;
    
    protected $order;
    
    protected $returnedItems;
    
    protected $countryFactory;
    
    protected $storeManager;
    
    public function __construct(
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\Filesystem\DirectoryList $directoryList,
        \Magento\Directory\Model\CountryFactory $countryFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->fileFactory = $fileFactory;
        $this->directoryList = $directoryList;
        $this->pageNumber = 0;
        $this->countryFactory = $countryFactory;
        $this->storeManager = $storeManager;
    }
    
    public function getPdf($order, $returnedItems){
        $this->font = \Zend_Pdf_Font::fontWithName(\Zend_Pdf_Font::FONT_HELVETICA);
        $this->fontBold = \Zend_Pdf_Font::fontWithName(\Zend_Pdf_Font::FONT_HELVETICA_BOLD);
        
        $this->order = $order;
        $this->returnedItems = $returnedItems;
        
        $pdf = new \Zend_Pdf();
        $pdf->pages[$this->pageNumber] = $pdf->newPage(\Zend_Pdf_Page::SIZE_A4); 
        
        $page = $pdf->pages[$this->pageNumber];
        
        $height = $page->getHeight();
        $width = $page->getWidth();
        
        $page = $this->drawHeader($page);
        
        $page = $this->drawBody($page);
        
        $page = $this->drawFooter($page);
        
        return $pdf;
    }
    
    public function getPdfImagePath(){
        $mediaPath = $this->directoryList->getPath('media');
        $pdfImagePath = $mediaPath . DIRECTORY_SEPARATOR . 'rma_pdf' . DIRECTORY_SEPARATOR;
        
        return $pdfImagePath;
    }
    
    public function drawBody($page){
        $style = new \Zend_Pdf_Style();
        $style->setLineColor(new \Zend_Pdf_Color_Rgb(0,0,0));
        $style->setLineDashingPattern([1], 0);
        $page->setStyle($style);
        
        //outer dashed rectangle
        $page->drawRectangle($this->x, $this->y - 480, $page->getWidth() - $this->x, $this->y, \Zend_Pdf_Page::SHAPE_DRAW_STROKE);
        
        //draw scissor image
        $scissorPath = $this->getPdfImagePath() . 'scissor.png';
        $image = \Zend_Pdf_Image::imageWithPath($scissorPath);
        $page->drawImage($image, 45, 595, 55, 605);
        
        $style->setFont($this->font,8);
        $style->setLineDashingPattern(0, 0);
        $page->setStyle($style);
        
        $page->drawText(__('Cut and Attach this form on the outside of the package'), 70, $this->y + 2, 'UTF-8');
        
        $style->setFont($this->font,8);
        $page->setStyle($style);
        //items list outer rectangle
        $page->drawRectangle(50, $this->y - 300, $page->getWidth() - 50, $this->y - 20, \Zend_Pdf_Page::SHAPE_DRAW_STROKE);
               
        $page->drawText(__('Order Number').":", 100, $this->y - 16, 'UTF-8');
        $page->drawRectangle(155, $this->y - 16, $page->getWidth() - 200, $this->y - 16, \Zend_Pdf_Page::SHAPE_DRAW_STROKE);
        $page->drawText("(".__('Required').")", $page->getWidth() - 198, $this->y - 16, 'UTF-8');
        $page->drawText($this->order->getIncrementId(), 156, $this->y - 15, 'UTF-8');
        
        //items list header rectangles
        $page->drawRectangle(50, $this->y - 60, $page->getWidth() - 340, $this->y - 20, \Zend_Pdf_Page::SHAPE_DRAW_STROKE);
        $page->drawRectangle($page->getWidth() - 340, $this->y - 60, $page->getWidth() - 275, $this->y - 20, \Zend_Pdf_Page::SHAPE_DRAW_STROKE);
        $page->drawRectangle($page->getWidth() - 275, $this->y - 60, $page->getWidth() - 210, $this->y - 20, \Zend_Pdf_Page::SHAPE_DRAW_STROKE);
        $page->drawRectangle($page->getWidth() - 210, $this->y - 60, $page->getWidth() - 50, $this->y - 20, \Zend_Pdf_Page::SHAPE_DRAW_STROKE);
        
        $style->setFont($this->font,10);
        $page->setStyle($style);
        $page->drawText(__('Product Name'), 110, $this->y - 40, 'UTF-8');
        $page->drawText(__('Color'), $page->getWidth() - 320, $this->y - 40, 'UTF-8');
        $page->drawText(__('Size'), $page->getWidth() - 255, $this->y - 40, 'UTF-8');
        $page->drawText(__('Reason'), $page->getWidth() - 160, $this->y - 40, 'UTF-8');
        
        //render return item rows rectangle
        $y1 = 80;
        $y2 = 60;
        for($itemsRow = 1; $itemsRow<=12; $itemsRow++) {
            $page->drawRectangle(50, $this->y - $y1, $page->getWidth() - 340, $this->y - $y2, \Zend_Pdf_Page::SHAPE_DRAW_STROKE);
            $page->drawRectangle($page->getWidth() - 340, $this->y - $y1, $page->getWidth() - 275, $this->y - $y2, \Zend_Pdf_Page::SHAPE_DRAW_STROKE);
            $page->drawRectangle($page->getWidth() - 275, $this->y - $y1, $page->getWidth() - 210, $this->y - $y2, \Zend_Pdf_Page::SHAPE_DRAW_STROKE);
            $page->drawRectangle($page->getWidth() - 210, $this->y - $y1, $page->getWidth() - 50, $this->y - $y2, \Zend_Pdf_Page::SHAPE_DRAW_STROKE);
            $y1 = $y1 + 20;
            $y2 = $y2 + 20;
        }
        
        $style->setFont($this->font,8);
        $page->setStyle($style);
        $colorY = 70;
        foreach($this->returnedItems as $item){
            $page->drawText($item['name'], 53, $this->y - $colorY, 'UTF-8');
            $page->drawText($item['color'], $page->getWidth() - 337, $this->y - $colorY, 'UTF-8');
            $page->drawText($item['size'], $page->getWidth() - 272, $this->y - $colorY, 'UTF-8');
            $page->drawText($item['reason'], $page->getWidth() - 207, $this->y - $colorY, 'UTF-8');
            $colorY += 20;
        }
        
        //sender/receiver information rectangle
        $page->drawRectangle(50, $this->y - 340, $page->getWidth() - 50, $this->y - 320, \Zend_Pdf_Page::SHAPE_DRAW_STROKE);
        $page->drawRectangle(50, $this->y - 470, $page->getWidth() - 270, $this->y - 340, \Zend_Pdf_Page::SHAPE_DRAW_STROKE);
        $page->drawRectangle($page->getWidth() - 270, $this->y - 470, $page->getWidth() - 50, $this->y - 340, \Zend_Pdf_Page::SHAPE_DRAW_STROKE);
        
        $style->setFont($this->font,8);
        $page->setStyle($style);
        $page->drawText(__('Order Number').":", 100, $this->y - 336, 'UTF-8');
        $page->drawRectangle(155, $this->y - 336, $page->getWidth() - 200, $this->y - 336, \Zend_Pdf_Page::SHAPE_DRAW_STROKE);
        $page->drawText("(".__('Required').")", $page->getWidth() - 198, $this->y - 336, 'UTF-8');
        $page->drawText($this->order->getIncrementId(), 156, $this->y - 335, 'UTF-8');
        
        $style->setFont($this->fontBold,8);
        $page->setStyle($style);
        $page->drawText(__('Sender') . ":", 55, $this->y - 350, 'UTF-8');
        
        $style->setFont($this->font,8);
        $page->setStyle($style);
        $page->drawText(__('Name'), 55, $this->y - 358, 'UTF-8');
        $page->drawText(__('Phone'), 55, $this->y - 390, 'UTF-8');
        $page->drawText(__('Address'), 55, $this->y - 415, 'UTF-8');
        
        $shippingAddress = $this->order->getShippingAddress();
        $streets = $shippingAddress->getStreet();
        $country = $this->countryFactory->create()->loadByCode($shippingAddress->getCountryId());
        $page->drawText($this->order->getCustomerName(), 55, $this->y - 368, 'UTF-8');
        $page->drawText($shippingAddress->getTelephone(), 55, $this->y - 400, 'UTF-8');
        $streetY = 425;
        foreach($streets as $street){
            $page->drawText($street, 55, $this->y - $streetY, 'UTF-8');
            $streetY += 10;
        }
        $page->drawText($shippingAddress->getCity(), 55, $this->y - $streetY, 'UTF-8');
        $page->drawText($country->getName(), 55, $this->y - ($streetY + 10), 'UTF-8');
        
        $style->setFont($this->fontBold,9);
        $page->setStyle($style);
        $page->drawText(__('Receiver') . ":", $page->getWidth() - 180, $this->y - 350, 'UTF-8');
        $page->drawText(__('PT. DELAMIBRANDS KHARISMA BUSANA'), $page->getWidth() - 260, $this->y - 360, 'UTF-8');
        
        $style->setFont($this->font,9);
        $page->setStyle($style);
        $page->drawText(__('e-Commerce Division'), $page->getWidth() - 210, $this->y - 370, 'UTF-8');
        $page->drawText(__('The Prominence Tower Lt.8'), $page->getWidth() - 225, $this->y - 380, 'UTF-8');
        $page->drawText(__('Jl. Jalur Sutera Barat No. 15'), $page->getWidth() - 225, $this->y - 390, 'UTF-8');
        $page->drawText(__('Alam Sutera, Tangerang 15143'), $page->getWidth() - 230, $this->y - 400, 'UTF-8');
        $page->drawText(__('Indonesia'), $page->getWidth() - 180, $this->y - 410, 'UTF-8');
        $page->drawText(__('Phone') . ": +62 21 2977 9599", $page->getWidth() - 210, $this->y - 420, 'UTF-8');
        
        $this->y = 100;
        
        return $page;
    }
    
    public function drawHeader($page){
        
        $storeCode = $this->storeManager->getStore()->getCode();
        
        if($storeCode == 'ID') {
            $logoPath = $this->getPdfImagePath() . "delami_bahasa.png";
        } else {
            $logoPath = $this->getPdfImagePath() . "delami.png";
        }
        
        $image = \Zend_Pdf_Image::imageWithPath($logoPath);
        
        $page->drawImage($image, $this->x, $this->y - 220, $page->getWidth() - $this->x, $this->y - 20);
        
        $this->y = 600;
        
        return $page;
    }
    
    public function drawFooter($page){
        $noticePath = $this->getPdfImagePath() . 'notice.png';
        
        $image = \Zend_Pdf_Image::imageWithPath($noticePath);
        
        $page->drawImage($image, $this->x, $this->y - 20, 40, $this->y - 10);
        
        $style = new \Zend_Pdf_Style();
        $style->setLineColor(new \Zend_Pdf_Color_Rgb(0,0,0));
        $style->setFont($this->font,8);
        $page->setStyle($style);
        
        $page->drawText("* " . __('Refunds won\'t be processed if you don\'t fill this form.'), 50, $this->y - 15, 'UTF-8');
        $page->drawText("* " . __('You can refund within 7 days (including holidays) since the goods are received.'), 50, $this->y - 25, 'UTF-8');
        $page->drawText("* " . __('Intimates products can\'t be returned.'), 50, $this->y - 35, 'UTF-8');
        $page->drawText("* " . __('Items returned should be in an unused and not washed.'), 50, $this->y - 45, 'UTF-8');
        $page->drawText(__('Item must be in the same condition as when you received the goods.'), 55, $this->y - 55, 'UTF-8');
        $page->drawText("(".__('complete with price tag and receipt').")", 55, $this->y - 65, 'UTF-8');
        
        return $page;
    }
    
}