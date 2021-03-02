// import * as THREE from 'three/build/module.js';
import {
	Scene,
	LoadingManager,
	PerspectiveCamera,
	WebGLRenderer,
	ACESFilmicToneMapping,
	PCFSoftShadowMap,
	sRGBEncoding,
	SpotLight,
	Group,
	UnsignedByteType,
	PMREMGenerator,
	TextureLoader
} from 'three/build/three.module.js';
import { OrbitControls } from 'three/examples/jsm/controls/OrbitControls.js';
import { RGBELoader } from 'three/examples/jsm/loaders/RGBELoader.js';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader.js';

export default class KitchenViewer {
	constructor(options) {
		/**
		 * @example options
		 * {
		 * 	container: document.querySelector('#canvas-container'),
		 * 
		 * 	cameraPosition: [-22,0,12],
		 * 
		 * 	hdrPath: 'data/hdr/file.hdr',
		 * 	modelPath: 'data/gltf/file.gltf',
		 * 
		 * 	textures: ['rock.png'],
		 * 	normalMaps: ['wood.jpg'],
		 * 
		 * 	onstart: function (url, itemsLoaded, itemsTotal) {},
		 * 	onprogress: function (url, itemsLoaded, itemsTotal) {},
		 * 	onload: function () {},
		 *	}
		 */

		const container = options.container;
		const scene = this.scene = new Scene();

		this.textures = {};
		this.normalMaps = {};

		//#region region LOADING MANAGER
		this.manager = new LoadingManager();
		this.manager.onStart = function (url, itemsLoaded, itemsTotal) {
			// console.log('>> Started loading file: ' + url + '.\nLoaded ' + itemsLoaded + ' of ' + itemsTotal + ' files.');
			if (typeof options.onstart === "function") {
				options.onstart(url, itemsLoaded, itemsTotal);
			}
		}
		this.manager.onProgress = function (url, itemsLoaded, itemsTotal) {
			// console.log('>> Loading file: ' + url + '.\nLoaded ' + itemsLoaded + ' of ' + itemsTotal + ' files.');
			if (typeof options.onprogress === "function") {
				options.onprogress(url, itemsLoaded, itemsTotal);
			}
		}
		this.manager.onLoad = () => {
			// console.log('>> Loading complete!');
			if (typeof options.onload === "function") {
				options.onload(this);
			}
		}
		//#endregion

		//#region PRELOAD ASSETS
		if (options.hdrPath) {
			this.loadHdr(options.hdrPath);
		}

		if (options.textures) {
			this.loadTextures(options.textures)
		}

		if (options.normalMaps) {
			this.loadNormalMaps(options.normalMaps);
		}

		if (options.modelPath) {
			this.loadModel(options.modelPath);
		}
		//#endregion

		//#region CAMERA
		const camera = this.camera = new PerspectiveCamera(45, container.offsetWidth / container.offsetHeight, 0.1, 100);
		if (options.cameraPosition) {
			camera.position.set(...options.cameraPosition);
		}
		else {
			camera.position.set(-22, 0, 0);
		}
		//#endregion

		//#region RENDERER
		const renderer = this.renderer = new WebGLRenderer({
			antialias: true,
			preserveDrawingBuffer: true // for screenshot
		});
		renderer.setClearColor(0xffffff, 1); //Фоновый цвет
		// renderer.setPixelRatio(1);
		renderer.setSize(container.offsetWidth, container.offsetHeight);
		renderer.toneMapping = ACESFilmicToneMapping;
		renderer.toneMappingExposure = 0.5;
		renderer.shadowMap.enabled = true;
		renderer.shadowMap.type = PCFSoftShadowMap;
		renderer.outputEncoding = sRGBEncoding;
		container.appendChild(renderer.domElement);
		//#endregion

		//#region LIGHTS
		// var ambientLight = new AmbientLight(0xffffff, 0.2); //Ambient light
		// this.scene.add(ambientLight);

		const Light_TOP = new SpotLight(0xdfffff, 0.3);
		Light_TOP.position.set(-12, 15, 0);
		Light_TOP.castShadow = true;
		Light_TOP.visible = true;
		Light_TOP.shadow.mapSize.width = 2048;
		Light_TOP.shadow.mapSize.height = 2048;
		Light_TOP.shadow.bias = -0.0001;

		const Light_RIGHT = new SpotLight(0xffffff, 0.35);
		Light_RIGHT.position.set(-10, 11, 8);
		Light_RIGHT.castShadow = true;
		Light_RIGHT.visible = true;
		Light_RIGHT.shadow.mapSize.width = 2048;
		Light_RIGHT.shadow.mapSize.height = 2048;
		Light_RIGHT.shadow.bias = -0.0001;

		const Light_LEFT = new SpotLight(0xffffff, 0.3);
		Light_LEFT.position.set(-6, 10, -8);
		Light_LEFT.castShadow = true;
		Light_LEFT.visible = true;
		Light_LEFT.shadow.mapSize.width = 2048;
		Light_LEFT.shadow.mapSize.height = 2048;
		Light_LEFT.shadow.bias = -0.0001;

		const lightGroup = new Group();
		lightGroup.add(Light_TOP);
		lightGroup.add(Light_RIGHT);
		lightGroup.add(Light_LEFT);
		scene.add(lightGroup);
		//#endregion

		//#region CONTROLS
		const controls = this.controls = new OrbitControls(camera, renderer.domElement);
		controls.minDistance = 10;
		controls.maxDistance = 30;
		controls.enablePan = false;
		controls.enableDamping = true;
		controls.dampingFactor = 0.15;
		// controls.rotateSpeed = 0.25;
		// controls.zoomSpeed = 0.5;

		// smooth Zoom
		// controls.constraint.smoothZoom = true;
		// controls.constraint.zoomDampingFactor = 0.15;
		// controls.constraint.smoothZoomSpeed = 5.0;

		controls.minPolarAngle = Math.PI / 4; // radians
		controls.maxPolarAngle = Math.PI / 1.5; // radians
		// controls.maxAzimuthAngle = - Math.PI / 17; // radians
		// controls.minAzimuthAngle = Math.PI / 0.98; // radians
		//#endregion

		//#region ON WINDOW RESIZE
		window.addEventListener('resize', () => {
			camera.aspect = container.offsetWidth / container.offsetHeight;
			camera.updateProjectionMatrix();
			renderer.setSize(container.offsetWidth, container.offsetHeight);
		}, false);
		//#endregion

		//#region RENDER
		const render = () => {
			controls.update();
			renderer.render(scene, camera);
			requestAnimationFrame(render);
		}
		//#endregion

		render();
	}

	loadHdr(path) {
		const loader = new RGBELoader(this.manager);
		loader.setDataType(UnsignedByteType);
		loader
			.load(
				path, texture => {
					const pmremGenerator = new PMREMGenerator(this.renderer);
					pmremGenerator.compileEquirectangularShader();
					// const envMap = pmremGenerator.fromEquirectangular(texture).texture;
					// this.scene.background = envMap;
					this.scene.environment = pmremGenerator.fromEquirectangular(texture).texture;
					texture.dispose();
					pmremGenerator.dispose();
				},
				progress => { /** console.log('Loading progress...', progress) */ },
				error => console.error('KitchenViewer.js >> loadHdr()', error)
			);
	}

	loadTextures(paths) {
		paths.map(path => {
			new TextureLoader(this.manager)
				.load(path,
					texture => {
						texture.flipY = false;
						// texture.wrapS = RepeatWrapping;
						// texture.wrapT = RepeatWrapping;
						// texture.repeat.set(1, 1);
						texture.encoding = sRGBEncoding;
						this.textures[path] = texture;
					},
					progress => { /** console.log('Loading progress...', progress) */ },
					error => console.error('KitchenViewer.js >> loadTextures()', error)
				);
		});
	}

	loadNormalMaps(paths) {
		paths.forEach(path => {
			new TextureLoader(this.manager)
				.load(path,
					texture => {
						texture.flipY = false;
						texture.encoding = sRGBEncoding;
						this.normalMaps[path] = texture;
					},
					progress => { /** console.log('Loading progress...', progress) */ },
					error => console.error('KitchenViewer.js >> loadNormalMaps()', error)
				);
		});
	}

	loadModel(path) {
		new GLTFLoader(this.manager)
			.load(path,
				gltf => {
					gltf.scene.traverse(child => {
						if (child.isMesh) {
							child.castShadow = true;
							child.receiveShadow = true;
						}
					});
					this.scene.add(gltf.scene);
				},
				progress => { /** console.log('Loading progress...', progress) */ },
				error => console.error('KitchenViewer.js >> loadModel()', error)
			);
	}

	/** Очистка цвета материала объекта */
	clearColor(targetName) {
		const target = this.scene.getObjectByName(targetName);
		if (target) {
			target.material.color.setHex('0xFFFFFF');
		}
	}

	/** Очистка текстуры материала объекта */
	clearTexture(targetName) {
		const target = this.scene.getObjectByName(targetName);
		if (target) {
			target.material.map = null;
			target.material.needsUpdate = true;
		}
	}

	/** Очистка карты нормалей объекта */
	clearNormalMap(targetName) {
		const target = this.scene.getObjectByName(targetName);
		if (target) {
			target.material.normalMap = null;
			target.material.needsUpdate = true;
		}
	}

	/** Смена цвета материала объекта */
	changeColor(targetName, color) {
		const target = this.scene.getObjectByName(targetName);
		if (target) {
			target.material.color.set(color);
		}
	}

	/** Смена текстуры материала объекта */
	changeTexture(targetName, textureName) {
		const target = this.scene.getObjectByName(targetName);
		if (target) {
			target.material.map = this.textures[textureName];
			target.material.needsUpdate = true;
		}
	}

	/** Смена матовости материала объекта */
	changeRoughness(targetName, value) {
		const target = this.scene.getObjectByName(targetName);
		if (target) {
			target.material.roughness = value;
		}
	}

	/** Смена карты матовости материала объекта */
	changeNormalMap(targetName, mapName) {
		const target = this.scene.getObjectByName(targetName);
		if (target) {
			target.material.normalMap = this.normalMaps[mapName];
		}
	}

	/** Сохранение изображения сцены в формат png */
	saveImage(filename) {
		this.renderer.domElement.toBlob((blob) => {
			let URLObj = window.URL || window.webkitURL;
			let a = document.createElement("a");
			a.href = URLObj.createObjectURL(blob);
			a.download = filename || "image.png";
			document.body.appendChild(a);
			a.click();
			document.body.removeChild(a);
		});
	}

	/** Сохранение изображения сцены в массив двоичных данных Blob */
	getBlob() {
		return new Promise((resolve, reject) => {
			this.renderer.domElement.toBlob(blob => {
				resolve(blob);
			});
		});
	}

	/** Сохранение изображения сцены в формат png c декодированием в base64 */
	// getBase64Png(options) {
	// 	if (options.pixelRatio) {
	// 		this.renderer.setPixelRatio(options.pixelRatio);
	// 		// this.render();
	// 	}
	// 	return new Promise((resolve, reject) => {
	// 		setTimeout(() => {
	// 			let base64 = this.renderer.domElement.toDataURL().replace("image/png", "image/octet-stream");
	// 			resolve(base64);
	// 			this.renderer.setPixelRatio(window.devicePixelRatio);
	// 			// this.render();
	// 		}, 300);
	// 	});
	// }
}