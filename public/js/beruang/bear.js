import * as THREE from 'https://cdn.skypack.dev/three@0.129.0';
import { GLTFLoader } from 'https://cdn.skypack.dev/three@0.129.0/examples/jsm/loaders/GLTFLoader.js';
import { OrbitControls } from 'https://cdn.jsdelivr.net/npm/three@0.121.1/examples/jsm/controls/OrbitControls.js';
// // Variables
let container, camera, renderer, scene, house

window.addEventListener('load',init)

function init() {
    container = document.querySelector('.scene')

    // Create scene
    scene = new THREE.Scene()
    const fov = 15
    const aspect = container.clientWidth / container.clientHeight
    const near = .1
    const far = 1000

    // Camera Setup
    camera = new THREE.PerspectiveCamera(fov, aspect, near, far)
    camera.position.set(0,75,500)

    const ambient = new THREE.AmbientLight(0x404040,2)
    // scene.add(ambient)

    const light = new THREE.DirectionalLight(0xffffff,5)
    light.position.set(10,10,100)
    scene.add(light)

    // Renderer
    renderer = new THREE.WebGLRenderer({antialias:true,alpha:true})
    renderer.setSize(container.clientWidth, container.clientHeight)
    renderer.setPixelRatio(window.devicePixelRatio)

    container.appendChild(renderer.domElement)

    // controls
    const controls = new OrbitControls( camera, renderer.domElement );

    // Load Model
    const loader = new GLTFLoader();
    loader.load('../js/beruang/scene.gltf',function(gltf){
        scene.add(gltf.scene)
        console.log(gltf)
        house = gltf.scene.children[0]
        animate()
    })
}

function animate(){
    requestAnimationFrame(animate)
    house.rotation.z = 7
    house.position.y = -50
    renderer.render(scene,camera)
}
