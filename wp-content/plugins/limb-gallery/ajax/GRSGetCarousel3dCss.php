<?php
/**
 * LIMB gallery
 * Get 3D Carousel CSS
 */

class GRSGetCarousel3dCss {
    // Costructor
    public function __construct() {
    }
    public function get_($id, $grsTheme) {
        $carousel3d = ".grsTemplate".$id." .grsCarousel3d {
			display: block;
			width: 100%;
			height: 100%;
			background-color: ". $grsTheme->crs3dBgColor .";
			margin: ". $grsTheme->crs3dMargin ."px 0px;
			position: relative;
		    overflow: hidden;
		}
		.grsTemplate".$id." .grsCarousel3d > .grsCrs3dImFIsC {
			height: 100%;
			position: relative;
		}
		.grsTemplate".$id." .grsCarousel3d > .grsCrs3dImFIsC > .grsCrs3dImFrCont {
		    box-sizing: border-box;
			background-color: ". $grsTheme->crs3dThumbBgColor .";
			margin: 0;
			padding: ". $grsTheme->crs3dThumbPadding ."px;
			box-shadow: ". $grsTheme->crs3dThumbBoxshadowFstVal ."px ". $grsTheme->crs3dThumbBoxshadowSecVal ."px ". $grsTheme->crs3dThumbBoxshadowThdVal ."px ". $grsTheme->crs3dThumbBoxshadowColor .";
			-moz-box-shadow: ". $grsTheme->crs3dThumbBoxshadowFstVal ."px ". $grsTheme->crs3dThumbBoxshadowSecVal ."px ". $grsTheme->crs3dThumbBoxshadowThdVal ."px ". $grsTheme->crs3dThumbBoxshadowColor .";
			-webkit-box-shadow: ". $grsTheme->crs3dThumbBoxshadowFstVal ."px ". $grsTheme->crs3dThumbBoxshadowSecVal ."px ". $grsTheme->crs3dThumbBoxshadowThdVal ."px ". $grsTheme->crs3dThumbBoxshadowColor .";
			border: ". $grsTheme->crs3dThumbBorderWidth ."px ". $grsTheme->crs3dThumbBorderStyle ." ". $grsTheme->crs3dThumbBorderColor ."; 
			float: left;
			position: absolute;
			top: 0;
			left: 0;
			overflow: hidden;";
        switch($grsTheme->crs3dHoverEffect) {
            case 'scale':
            case 'rotate':
                $carousel3d .= "-webkit-transition: 0.1s transform linear, 0.5s left linear, 0.5s top linear, 0.5s width linear, 0.5s height linear;
						-ms-transition: 0.1s transform linear, 0.5s left linear, 0.5s top linear, 0.5s width linear, 0.5s height linear;
							transition: 0.1s transform linear, 0.5s left linear, 0.5s top linear, 0.5s width linear, 0.5s height linear;";
                break;
            case 'grayscale':
                $carousel3d .= "-webkit-transition: 0.5s ease-in-out;
							transition: 0.5s ease-in-out;
					-webkit-filter: grayscale(100%);
							filter: grayscale(100%);";
                break;
            case 'blur':
                $carousel3d .= "-webkit-filter: grayscale(0) blur(0);
							filter: grayscale(0) blur(0);
					-webkit-transition: 0.5s ease-in-out;
							transition: 0.5s ease-in-out;";
                break;
            case 'sepia':
                $carousel3d .= "-webkit-filter: sepia(100%);
							filter: sepia(100%);
					-webkit-transition: 0.5s ease-in-out;
							transition: 0.5s ease-in-out;";
                break;
            case 'flash':
            case 'shine':
            case 'circle':
            default:
                $carousel3d .= "-webkit-transition: 0.5s left linear, 0.5s top linear,  0.5s width linear, 0.5s height linear;
						-ms-transition: 0.5s left linear, 0.5s top linear,  0.5s width linear, 0.5s height linear;
							transition: 0.5s left linear, 0.5s top linear,  0.5s width linear, 0.5s height linear;";
                break;
        }
        $carousel3d .= "}";
        if($grsTheme->crs3dHoverEffect == 'shine') {
            $carousel3d .= ".grsTemplate".$id." .grsCarousel3d > .grsCrs3dImFIsC > .grsCrs3dImFrCont::before {
				position: absolute;
				top: 0;
				left: -75%;
				z-index: 2;
				display: block;
				content: '';
				width: 50%;
				height: 100%;
				background: -webkit-linear-gradient(left, rgba(255,255,255,0) 0%, rgba(255,255,255,.3) 100%);
				background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,.3) 100%);
				-webkit-transform: skewX(-25deg);
				transform: skewX(-25deg);
			}
			.grsTemplate".$id." .grsCarousel3d > .grsCrs3dImFIsC > .grsCrs3dImFrCont:hover::before {
				-webkit-animation: shine .75s;
						animation: shine .75s;
			}";
        } elseif($grsTheme->crs3dHoverEffect == 'circle') {
            $carousel3d .= ".grsTemplate".$id." .grsCarousel3d > .grsCrs3dImFIsC > .grsCrs3dImFrCont::before {
				position: absolute;
				top: 50%;
				left: 50%;
				z-index: 2;
				display: block;
				content: '';
				width: 0;
				height: 0;
				background: rgba(255,255,255,.2);
				border-radius: 100%;
				-webkit-transform: translate(-50%, -50%);
				transform: translate(-50%, -50%);
				opacity: 0;
			}
			.grsTemplate".$id." .grsCarousel3d > .grsCrs3dImFIsC > .grsCrs3dImFrCont:hover::before {
				-webkit-animation: circle .75s;
						animation: circle .75s;
			}";
        }
        $carousel3d .= ".grsTemplate".$id." .grsCarousel3d > .grsCrs3dImFIsC > .grsCrs3dImFrCont:hover {";
        switch($grsTheme->crs3dHoverEffect) {
            case 'scale':
                $carousel3d .= "-webkit-transform: scale(1.1);
						-ms-transform: scale(1.1);
						transform: scale(1.1);
						z-index: 2;";
                break;
            case 'rotate':
                $carousel3d .= "-webkit-transform: rotate(3.5deg);
						-ms-transform: rotate(3.5deg);
						transform: rotate(3.5deg);
						z-index: 2;";
                break;
            case 'grayscale':
                $carousel3d .= "-webkit-filter: grayscale(0);
							filter: grayscale(0);";
                break;
            case 'blur':
                $carousel3d .= "-webkit-filter: grayscale(100%) blur(1px);
							filter: grayscale(100%) blur(1px);";
                break;
            case 'sepia':
                $carousel3d .= "-webkit-filter: sepia(0);
							filter: sepia(0);";
                break;
            case 'flash':
                $carousel3d .= "opacity: 1;
						-webkit-animation: flash 1.5s;
								animation: flash 1.5s;";
                break;
            case 'shine':
                break;
            case 'circle':
                break;
            default:
                break;
        }
        $carousel3d .= "}";
        $carousel3d .= ".grsTemplate".$id." .grsCarousel3d .grsCrs3dImFIsC > .grsCrs3dImFrCont:last-child {
			margin: 0;
		}
		.grsTemplate".$id." .grsCarousel3d > .grsCrs3dImFIsC > .grsCrs3dImFrCont > .grsImsBox {
		    overflow: hidden;
		    text-decoration: none;
		    box-shadow: none;
		    border: none;
		    outline: none;
		    z-index: 1;
		}
		.grsTemplate".$id." .grsCarousel3d > .grsCrs3dImFIsC > .grsCrs3dImFrCont > .grsImsBox > .grsImsMainC { 
			position: relative;
		    height: 100%;
		    width: 100%;
		    overflow: hidden;
		}
		.grsTemplate".$id." .grsCarousel3d > .grsCrs3dImFIsC > .grsCrs3dImFrCont > .grsImsBox > .grsImsMainC > .grsCrs3dImFrContbck {
			background-color: ". $grsTheme->crs3dThumbBgColor .";
			background-size: cover !important;
			background-repeat: no-repeat;
			background-position: center;
			position: relative;
			width: 100%;
			height: 100%;
			-webkit-transition: 0.3s transform ease-in-out;
			transition: 0.3s transform ease-in-out;";
        switch($grsTheme->crs3dHoverEffect) {
            case 'scaleIm':
                $carousel3d .= "-webkit-transform: scale3d(1,1,1);
						-ms-transform: scale3d(1,1,1);
							transform: scale3d(1,1,1);";
                break;
            case 'scaleRotIm':
                $carousel3d .= "-webkit-transform: rotate(0deg) scale3d(1,1,1);
						-ms-transform: rotate(0deg) scale3d(1,1,1);
							transform: rotate(0deg) scale3d(1,1,1);";
                break;
            case 'scaleTransIm':
                $carousel3d .= "-webkit-transform: scale3d(1,1,1) translate(0px);
						-ms-transform: scale3d(1,1,1) translate(0px);
							transform: scale3d(1,1,1) translate(0px);";
                break;
            default:
                break;
        }
        $carousel3d .= "}";
        $carousel3d .= ".grsTemplate".$id." .grsCarousel3d > .grsCrs3dImFIsC > .grsCrs3dImFrCont:hover > .grsImsBox > .grsImsMainC > .grsCrs3dImFrContbck {";
        switch($grsTheme->crs3dHoverEffect) {
            case 'scaleIm':
                $carousel3d .= "-webkit-transform: scale3d(1.2, 1.2, 1.2);
						-ms-transform: scale3d(1.2, 1.2, 1.2);
							transform: scale3d(1.2, 1.2, 1.2);";
                break;
            case 'scaleRotIm':
                $carousel3d .= "-webkit-transform: scale3d(1.2,1.2,1.2) rotate(5deg);
						-ms-transform: scale3d(1.2,1.2,1.2) rotate(5deg);
							transform: scale3d(1.2,1.2,1.2) rotate(5deg);";
                break;
            case 'scaleTransIm':
                $carousel3d .= "-webkit-transform: scale3d(1.2,1.2,1.2) translate(15px);
						-ms-transform: scale3d(1.2,1.2,1.2) translate(15px);
							transform: scale3d(1.2,1.2,1.2) translate(15px);";
                break;
            default:
                break;
        }
        $carousel3d .= "}";
        $carousel3d .= ".grsTemplate".$id." .grsCarousel3d > .grsCrs3dImFIsC > .grsCrs3dImFrCont > .grsImsBox > .grsImsMainC > .grsMask  {
			overflow: hidden;
			width: 100%;
			height: 100%;
			position: absolute;
			top: 0px;
			left: 0px;
			z-index: 2;
		}
		.grsTemplate".$id." .grsCarousel3d > .grsCrs3dImFIsC > .grsCrs3dImFrCont > .grsImsBox > .grsImsMainC > .grsCrs3dTitleC {
			background-color: ". $grsTheme->crs3dTBgcolor .";
			padding: ". $grsTheme->crs3dTpadding ."px;
			box-sizing: border-box;
			position: absolute;
			overflow: hidden;
			height: 100%;
			width: 100%;
			left: 0px;
			top: 0px;
		    z-index: 2;
			-webkit-animation-duration: 1s;
					animation-duration: 1s;	  
			-webkit-animation-fill-mode: both;
					animation-fill-mode: both;
			-webkit-animation-delay: 0.1s;
					animation-delay: 0.1s;
		}
		.grsTemplate".$id." .grsCarousel3d > .grsCrs3dImFIsC > .grsCrs3dImFrCont > .grsImsBox > .grsImsMainC > .grsCrs3dTitleC.grsTOnhover {
			transition: all 500ms linear;
			transition-timing-function: ease-in-out;
			-webkit-perspective: 100px;
					perspective: 100px;";
        switch($grsTheme->crs3dThumbTeffect) {
            case 'grsFadeIn':
                $carousel3d .= "opacity: 0;";
                break;
            case 'grsSlideInLeft':
                $carousel3d .= "-webkit-transform: translateX(-50%);
					transform: translateX(-50%);
					opacity: 0;";
                break;
            case 'grsSlideInRight':
                $carousel3d .= "-webkit-transform: translateX(50%);
					transform: translateX(50%);
					opacity: 0;";
                break;
            case 'grsSlideInUp':
                $carousel3d .= "-webkit-transform: translateY(50%);
					transform: translateY(50%);
					opacity: 0;";
                break;
            case 'grsSlideInDown':
                $carousel3d .= "-webkit-transform: translateY(-50%);
					transform: translateY(-50%);
					opacity: 0;";
                break;
            case 'grsZoomIn':
                $carousel3d .= "-webkit-transform: scale3d(0.7, 0.7, 0.7);
					transform: scale3d(0.7, 0.7, 0.7);
    				opacity: 0;";
                break;
            case 'grsTransUp':
                $carousel3d .= "-webkit-transform: rotateX(5deg) translate3d(0,10px,0);
	                    -ms-transform: rotateX(5deg) translateY(10px);
	    					transform: rotateX(5deg) translate3d(0,10px,0);
					-webkit-transform-origin: 0 100%;
	                    -ms-transform-origin: 0 100%;
	                        transform-origin: 0 100%;
	                opacity: 0;";
                break;
            case 'grsRotateX':
                $carousel3d .= "-webkit-transform: rotateX(100deg);
	                    -ms-transform: rotateX(100deg);
	                        transform: rotateX(100deg);
	                -webkit-transform-origin: 100% 0%;
                        -ms-transform-origin: 100% 0%;
	           				transform-origin: 100% 0%;
	           		opacity: 0;";
                break;
            case 'grsRotateY':
                $carousel3d .= "-webkit-transform: rotateY(100deg);
	                    -ms-transform: rotateY(100deg);
	    					transform: rotateY(100deg);
	                -webkit-transform-origin: 0% 100%;
	                    -ms-transform-origin: 0% 100%;
	    					transform-origin: 0% 100%;
	    			opacity: 0;";
                break;
            case 'grsBounceIn':
            case 'grsBounceInDown':
            case 'grsBounceInLeft':
            case 'grsFlipInX':
            case 'grsFlipInY':
            case 'grsRollIn':
                $carousel3d .= "opacity: 0;";
                break;
            default:
                break;
        }
        $carousel3d .= "}";
        $carousel3d .= ".grsTemplate".$id." .grsCarousel3d > .grsCrs3dImFIsC > .grsCrs3dImFrCont:hover > .grsImsBox > .grsImsMainC > .grsCrs3dTitleC.grsTOnhover {";
        switch($grsTheme->crs3dThumbTeffect) {
            case 'grsFadeIn':
                $carousel3d .= "opacity: 1;";
                break;
            case 'grsSlideInLeft':
            case 'grsSlideInRight':
            case 'grsSlideInUp':
            case 'grsSlideInDown':
                $carousel3d .= "-webkit-transform: translateY(0%);
							transform: translateY(0%);
					-webkit-transform: translate(0%, 0%);
							transform: translate(0%, 0%);
					opacity: 1;";
                break;
            case 'grsZoomIn':
                $carousel3d .= "-webkit-transform: scale3d(1, 1, 1);
    						transform: scale3d(1, 1, 1);
					opacity: 1;";
                break;
            case 'grsTransUp':
                $carousel3d .= "-webkit-transform: rotateX(0deg) translate3d(0px,0px,0px);
			                transform: rotateX(0deg) translate3d(0px,0px,0px);
	                opacity: 1;";
                break;
            case 'grsRotateX':
                $carousel3d .= "-webkit-transform: rotateX(0deg);
                        -ms-transform: rotateX(0deg);
    						transform: rotateX(0deg);
    				opacity: 1;";
                break;
            case 'grsRotateY':
                $carousel3d .= "-webkit-transform: rotateY(0deg);
	                    -ms-transform: rotateY(0deg);
	   						transform: rotateY(0deg);
	   				opacity: 1;";
                break;
            case 'grsBounceIn':
            case 'grsBounceInDown':
            case 'grsBounceInLeft':
            case 'grsFlipInY':
            case 'grsFlipInX':
            case 'grsRollIn':
                $carousel3d .= "-webkit-animation-name: ". $grsTheme->crs3dThumbTeffect .";
							animation-name: ". $grsTheme->crs3dThumbTeffect .";
					opacity: 1;";
                break;
            default:
                break;
        }
        $carousel3d .= "}";
        $carousel3d .= ".grsTemplate".$id." .grsCarousel3d > .grsCrs3dImFIsC > .grsCrs3dImFrCont > .grsImsBox > .grsImsMainC .grsCrs3dTitleCT > .grsCrs3dTitleCC > .grsCrs3dTitle {
			font-weight: ". $grsTheme->crs3dTFWeight .";
			font-family: ". $grsTheme->crs3dTFFamily .";
			font-size: ". $grsTheme->crs3dTFSize ."px;
			font-style: ". $grsTheme->crs3dTFstyle .";
			color: ". $grsTheme->crs3dTcolor .";
			word-break: break-word;
			text-align: center;
		}
		.grsTemplate".$id." .grsCarousel3d > .grsCrs3dImFIsC > .grsCrs3dImFrCont > .grsImsBox > .grsImsMainC .grsCrs3dTitleCT > .grsCrs3dTitleCC {
			display: table-cell;
			vertical-align: ". $grsTheme->crs3dTpos .";
			width: 100%;
			height: 100%;
		}
		.grsTemplate".$id." .grsCarousel3d > .grsCrs3dImFIsC > .grsCrs3dImFrCont > .grsImsBox > .grsImsMainC > .grsMask > .grsImHovEf {
			padding: ". $grsTheme->crs3dTpadding ."px;
			box-sizing: border-box;
			width: 100%;
			height: 100%;
			position: absolute;
			overflow: hidden;
			top: 0;
			left: 0;
			text-align: center;
			opacity: 0;
			font-size: 12px;
			transform: rotate(-33.5deg) translate(-112px,166px);
			transform-origin: 0% 100%;
			transition: all 0.4s ease-in-out 0.3s;
			z-index: 2;
		}
		.grsTemplate".$id." .grsCarousel3d > .grsCrs3dImFIsC > .grsCrs3dImFrCont > .grsImsBox > .grsImsMainC > .grsMask .mask-1,
		.grsTemplate".$id." .grsCarousel3d > .grsCrs3dImFIsC > .grsCrs3dImFrCont > .grsImsBox > .grsImsMainC > .grsMask .mask-2 {
			position: absolute;
			background-color: rgba(0,0,0,0.75);/*thumbnailMaskColor*/
			width: 100%;
			opacity: 1;
			transition: all 0.3s ease-in-out 0.6s;
			z-index: 3;
		}
		.grsTemplate".$id." .grsCarousel3d > .grsCrs3dImFIsC > .grsCrs3dImFrCont > .grsImsBox > .grsImsMainC > .grsMask .mask-1 {
			top: 0px;
			height: 0%;
		}
		.grsTemplate".$id." .grsCarousel3d > .grsCrs3dImFIsC > .grsCrs3dImFrCont > .grsImsBox > .grsImsMainC > .grsMask .mask-2 {
			bottom: 0px;
			height: 0%;
		}
		.grsTemplate".$id." .grsCarousel3d > .grsCrs3dImFIsC > .grsCrs3dImFrCont > .grsImsBox > .grsImsMainC > .grsMask:hover .grsImHovEf {
			opacity: 1;
			transform: rotate(0deg) translate(0px,0px);
			z-index:3
		}
		.grsTemplate".$id." .grsCarousel3d > .grsCrs3dImFIsC > .grsCrs3dImFrCont > .grsImsBox > .grsImsMainC > .grsMask:hover .mask-1,
		.grsTemplate".$id." .grsCarousel3d > .grsCrs3dImFIsC > .grsCrs3dImFrCont > .grsImsBox > .grsImsMainC > .grsMask:hover .mask-2{
			transition-delay: 0s;
		}
		.grsTemplate".$id." .grsCarousel3d > .grsCrs3dImFIsC > .grsCrs3dImFrCont > .grsImsBox > .grsImsMainC > .grsMask:hover .mask-1{
			height: 50%;
		}
		.grsTemplate".$id." .grsCarousel3d > .grsCrs3dImFIsC > .grsCrs3dImFrCont > .grsImsBox > .grsImsMainC > .grsMask:hover .mask-2 {  
			height: 50%;
		}
		.grsTemplate".$id." .grsCarousel3d > .grsCrs3dImFIsC > .grsCrs3dImFrCont > .grsImsBox > .grsImsMainC .grsCrs3dTitleCT {
			display: table;
			width: 100%;
			height: 100%;
		}";
        return $carousel3d;
    }
}