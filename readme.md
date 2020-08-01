# BaseModule
Základní modul celé aplikace, obsahuje společné třídy, komponenty, assety, atp. Spojuje celou aplikaci.

**Namespace:** `Wakers\BaseModule\<folder>\*`.

**Vzorová třída:** `Wakers\BaseModule\Component\Admin\BreadCrumb\BreadCrumb`


## Komponenty

### Admin (site-manager)
1. `Admin\BaseControl` - Předek všech Admin komponent - napříč celou aplikací (všechny Admin komponenty od něj dědí).
2. `Admin\NavBar` - generuje navigační (dropdown) menu v site-manageru.
3. `Admin\Bradcrumb` - generuje drobečkové menu v site-manageru.

### Common (společné Admin i Frontend)
1. `Common\BaseControl` - Předek všech Common komponent - napříč celou aplikací (všechny Common komponenty od něj dědí).
2. `Common\AssetLoader` - zajištuje načítání JS, CSS, Fontů a dalších statických souborů.
3. `Common\Logout (HandleLogout)` - zajištuje odhlašování uživatelů.
4. `Common\Modal (HandleModalToggle)` - zajištuje otevírání modálních oken skrze PHP.
5. `Common\Notification` - zajištuje výpis notifikací skrze PHP.
6. `Common\PermissionWatcher` - porovnává identitu přihlášeného uživatele (zda-li nebyla změněna v DB).

### Frontend
1. `Frontend\BaseControl` - Předek všech Frontend komponent - napříč celou aplikací (všechny Frontend komponenty od něj dědí).
2. `Frontend\DashboardModal` - modální okno s Dashboardem (sestaví podle použitých modulů - dle app.neon `parameters.dashboard`).

## Buildery

### ACL Builder
1. `Builder\AclBuilderFactory` - registuje celý ACL do DI podle použitých modulů.
2. `Builder\AuthorizatorBuilder` - předek všech Authorizátorů (osatatní od něj musí dědit).

Každý modulový Authorizator se musí registrovat v config.neon v sekci `parameters.acl`.

## Presenter a layout
Pro všechny modulové AdminPresentry - napříč celou aplikací existuje předek `Presenter\BaseAdminPresenter`.

2. `Presenter\BaseAdminPresenter` načítá výchozí layout: `@layout.latte`, v modulech lze tedy používat pouze view. 
3. `Presenter\AdminPresenter` - Admin presenter pro base-module (lze zde registrovat komponenty pro base-module).

## Util

### Ajaxová validace formulářů
`Util\AjaxValidate` - traita s metodou `success`, kterou lze využít při validaci formulářu.

1. Př: `$form->onValidate[] = function (Form $form) { $this->validate($form) };`.


### Práce se soubory
Pro práci se soubory slouží třída `Wakers\BaseModule\Util\ProtectedFile`.

1. Ukládá soubory do neveřejného adresáře.
2. Pomocí 2 základních metod či maker lze soubory zpřístupnit.
3. Zajištuje i generování náhledových obrázků (ořezů).

#### Nahrávání souboru
1. Z formuláře přijde objekt typu `Nette\Http\FileUpload $fileUpload`.
2. Vytvoříme instanci `ProtectedFile $protectedFile` a uložíme soubor.

```PHP
$protectedFile = new ProtectedFile('my-super/sub-folder/', NULL);
$tmsName = $protectedFile->move($fileUpload); // vrací unikátní název

// ... Název někam uložíme - třeba do DB
```

##### Odstranění souborů
1. Načteme název souboru.
2. Vytvoříme instanci `ProtectedFile $protectedFile`, **již s názvem souboru**.
3. Následně soubor odstraníme (z neveřejného i veřejného adresáře).

```PHP
$name = 'nahled.jpg' // Načteno např. z DB
$protectedFile = new ProtectedFile('my-super/sub-folder/', $name);
$protectedFile->remove();
```


#### Publikování souboru / vytvoření ořezu
Publikování souboru či obrázku se může řešit na úrovni šablony viz latte šablona.

1. Načteme název souboru.
2. Vytvoříme instanci `ProtectedFile $protectedFile` **s názvem souboru** a přidáme mu i extra atribut.
3. Soubor vypíšeme v šabloně a vypíšeme i atribut.

##### Příklad PHP (Repository):
```PHP
$name = 'nahled.jpg'; // Načteno např. z DB
$title = 'Titulek obrázku'; // Načteno např. z DB

$protectedFile = new ProtectedFile('my-super/sub-folder/', $name);
$protectedFile->setAttr('title', $title);
```

##### Příklad Latte:
```LATTE

{* Makro file vytvoří kopii souboru do veřejného adresáře a vrátí cestu k souboru *}

<a href="{file $protectedFile}">Odkaz na soubor</a>

{* nebo *}

<a href="{$basePath . $protectedFile->getFile()}">Odkaz na soubor</a>


{* Makro img vytvoří oříznutý obrázek a vrátí cestu k souboru
   Pokud soubor ještě nebyl nahrán (neexistuje privátní soubor), vytvoří šedý obrázek *}

<img src="{img $protectedFile, '1200xNULL', 'SHRINK_ONLY'}" title="{$protctedFile->getAttr('title')}">

{* nebo *}

<img src="{$basePath . $protectedFile->getPublicImage('1200xNULL', 'SHRINK_ONLY')}" title="{$protectedFile->getAttr('title')}">


{* Vypíše pouze, pokud existuje privátní soubor - nevytváří tedy šedý obrázek *}

{if $protectedFile->getPrivateFile()})
    <img src="{img $protectedFile, '1200xNULL', 'SHRINK_ONLY'}" title="{$protctedFile->getAttr('title')}">
{/if}
```