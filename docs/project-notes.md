# Strangeday

## De que se trata el proyecto

Strangeday es un proyecto editorial construido alrededor de una imagen principal. Cada pieza parte de una fotografia y de lo que esa imagen inspira: una cancion, una receta, o ambas cosas al mismo tiempo.

La experiencia principal del sitio no sera la de un blog clasico. La navegacion y lectura estaran pensadas como una composicion de tres columnas:

1. La primera columna muestra la pieza principal y siempre permanece visible.
2. La segunda columna despliega la musica relacionada cuando existe.
3. La tercera columna despliega la receta relacionada cuando existe.

La lectura del sitio debe sentirse editorial, lateral y contextual: la imagen principal nunca desaparece mientras el contenido complementario se abre a la derecha.

## Implementacion propuesta

- El sitio se construira como un nuevo tema FSE creado con el plugin Create Block Theme.
- La logica de la interfaz de tres columnas se implementara para responder al contenido de una unidad principal propia del proyecto.
- Para la interactividad del frontend, la direccion actual es usar la Interactivity API de WordPress como capa de estado y coordinacion entre columnas.
- ACF se usara para definir los custom post types y sus campos.
- La experiencia principal de Strangeday no se montara sobre el tipo `post` nativo, para no mezclar este sistema editorial con un posible blog clasico futuro.

## Modelo de contenido

Tendremos tres custom post types:

### 1. `photo`

Es la unidad principal del sistema. Todo gira alrededor de una imagen y de la inspiracion que produce.

Cada `photo` representara una pieza editorial principal y alimentara la primera columna del layout.

### 2. `music`

Representa una pieza musical relacionada a una `photo`.

Este contenido alimentara la segunda columna del layout.

### 3. `recipes`

Representa una receta o plato relacionado a una `photo`.

Este contenido alimentara la tercera columna del layout.

## Relacion entre los CPTs

La relacion inicial propuesta es:

- `photo` sera el nodo principal.
- un `photo` podra relacionarse con:
  - cero o un `music`
  - cero o un `recipes`
- `music` y `recipes` funcionaran como contenidos complementarios que se abren desde `photo`.

En esta primera etapa la relacion sera unidireccional desde `photo`, porque coincide con la logica de la interfaz:

- columna 1 = `photo`
- columna 2 = `music`
- columna 3 = `recipes`

Este enfoque mantiene claro el modelo mental del sitio y evita complejidad innecesaria al comienzo.

## Nota de arquitectura

No se usara el tipo `post` como base de esta experiencia principal. Si en el futuro el proyecto necesita un blog clasico, ese blog podra vivir separado usando `post` nativo y sus propias plantillas.

## Archives y jerarquia de navegacion

Se podran crear archive pages para los tres CPTs:

- `archive-photo`
- `archive-music`
- `archive-recipes`

Sin embargo, no todos estos archives deben usar exactamente el mismo lenguaje de interfaz.

La experiencia principal del proyecto seguira siendo `photo` y su layout de tres columnas. Ese patron se considera la firma editorial de Strangeday y no debe convertirse automaticamente en el layout universal de todas las pantallas.

La jerarquia conceptual sera esta:

- `single-photo` = experiencia principal, inmersiva y contextual
- archives = exploracion, descubrimiento y navegacion
- `single-music` y `single-recipes` = vistas autonomas y canonicas de contenidos complementarios

## Criterio de layout

El layout de tres columnas se mantendra como sistema principal para `single-photo`.

Para los archives, la direccion actual es no forzar siempre ese mismo layout de tres columnas. En las vistas de archivo el objetivo principal sera facilitar el escaneo y el descubrimiento de multiples piezas, por lo que podran usar una estructura mas simple, mas editorial o mas cercana a un indice visual.

La idea central a preservar no es "usar siempre tres columnas", sino que una `photo` pueda abrir capas de contexto relacionadas.

## Singles de `music` y `recipes`

`music` y `recipes` tendran single propio.

La decision actual es que ambos contenidos deben existir de dos maneras:

1. Como detalle expandido dentro de una experiencia de exploracion, por ejemplo desde un archive.
2. Como pagina single autonoma, con permalink propio.

Esto permite conservar una navegacion rica dentro del sitio sin perder:

- URLs canonicas
- capacidad de compartir enlaces
- estructura clara para WordPress
- posibilidad de SEO y archivo historico

## Panel lateral y vista autonoma

En los archives de `music` y `recipes`, el detalle ideal no seria un salto inmediato a otra pagina, sino la apertura de un panel lateral o una capa expandida dentro de la misma experiencia de navegacion.

Ese panel funcionaria como vista rapida o vista contextual.

Al mismo tiempo, cada item seguira teniendo acceso a su single autonomo, que funcionara como version completa y permanente del contenido.

En sintesis:

- en navegacion cotidiana, `music` y `recipes` podran abrirse en panel lateral
- en estructura de contenido, `music` y `recipes` existiran tambien como single pages reales

Este enfoque combina una experiencia editorial fluida con una arquitectura de contenido robusta.

## Estado de estas notas

Este archivo funcionara como documento vivo de decisiones para el desarrollo. A medida que definamos estructura, campos, templates, interacciones y relaciones, iremos ampliandolo.
