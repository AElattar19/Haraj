$(function () {
  const mainLoader = $("#main__loader");
  const bootstrapFileLink = $("#bootstrapLink");
  const stylesheetFileLink = $("#stylefileLink");
  const languageToggler = $(".language-toggler .dropdown-menu button");

  const discountsSliderWrap = $(".owl-carousel.discountslider");
  const mainHeader = $("#main-header");
  const mainNavbar = mainHeader.find(".navbar");

  /* Company Data Form page */
  const signFormWrap = $("#signasrestrant");
  const fileUploadsInputOne = $("#step-3 #file1");
  const fileUploadsInputTwo = $("#step-3 #file2");
  const fileUploadsInputThree = $("#step-3 #file3");

  let SITE_DIRECTION = $("body").css("direction");

  // Plugins
  AOS.init({ once: true });

  // Form Wizard
  if (signFormWrap.length) {
    const formWizordOption = {
      selected: 0,
      autoAdjustHeight: false,
      enableFinishButton: true,
      onFinish: () => {
        console.log("love");
      },
      lang: {
        next: "التالى",
      },
      toolbar: {
        showPreviousButton: false,
        extraHtml: `<button type="submit" class="btn btn-primary rounded-3 py-2 d-none submit__button "
        data-lang="lastsubmit_button">سجل معنا</button>`,
      },
      anchor: {
        enableNavigation: true,
      },
      keyboard: {
        keyNavigation: false,
      },
      style: {
        btnNextCss: "btn btn-primary rounded-3 py-2 next__button",
        toolbarCss: "text-center mt-4",
      },
    };
    signFormWrap.smartWizard(formWizordOption);

    const nextButton = $(".next__button");
    const submitButton = $(".submit__button");

    signFormWrap.on("loaded", function () {
      nextButton.attr("data-lang", "nextsubmit_button");
    });

    signFormWrap.on(
      "showStep",
      (e, anchorObject, stepIndex, stepDirection, stepPosition) => {
        if (stepPosition == "last") {
          submitButton.removeClass("d-none");
          nextButton.addClass("d-none");
        } else {
          submitButton.addClass("d-none");
          nextButton.removeClass("d-none");
        }
      }
    );
  }

  /* Dropzone section or files upload section
   Dropzone at Company data form page
   Handle File Uploads
   Here also , Form Submbit function */
  if (
    fileUploadsInputOne.length ||
    fileUploadsInputTwo.length ||
    fileUploadsInputThree.length
  ) {
    const fileuploadOptions = (url = "papers", paramName) => {
      return {
        url: url,
        uploadMultiple: false,
        maxFiles: 1,
        addRemoveLinks: true,
        paramName: paramName,
        parallelUploads: 1,
        autoProcessQueue: false,
        previewTemplate: $(".dropzone-preview").html(),
        sending: (file) => {
          console.log(file);
        },
      };
    };
    const serverFilesUploadedURL = "papers";

    const papersDropzone1 = new Dropzone(
      fileUploadsInputOne.get(0),
      fileuploadOptions(serverFilesUploadedURL, "paper1")
    );
    const papersDropzone2 = new Dropzone(
      fileUploadsInputTwo.get(0),
      fileuploadOptions(serverFilesUploadedURL, "paper2")
    );
    const papersDropzone3 = new Dropzone(
      fileUploadsInputThree.get(0),
      fileuploadOptions(serverFilesUploadedURL, "paper3")
    );

    signFormWrap.on("submit", (event) => {
      event.preventDefault();
      papersDropzone1.processQueue();
      papersDropzone2.processQueue();
      papersDropzone3.processQueue();
      // alert
      alert(
        "Form Submitted from 'Dropzone section or files upload section' at App.js file after form wizard section"
      );
      console.log("Form Submitted after files uploaded");
    });
  }

  // Global settings

  /* 
    (1)- Language settings
    (2)- Init plugins
  */

  // - Language settings
  languageToggler.each(function () {
    $(this).click(function () {
      let langType = $(this).data("lang-type");
      let dropdownToggler = $(".language-toggler .dropdown-toggle");

      if (!$(this).hasClass("active")) {
        mainLoader.show(10);
        const itemWillTranslate = $(`[data-lang]`);
        if (Boolean(LANGUAGES[langType])) {
          let langData = LANGUAGES[langType];

          if (itemWillTranslate.length) {
            itemWillTranslate.each(function () {
              let itemName = $(this).data("lang").trim();

              if ($(this).is("input") || $(this).is("textarea")) {
                $(this).attr("placeholder", langData[itemName]);
              } else if ($(this).is("img")) {
                $(this).attr("src", langData[itemName]);
              } else {
                $(this).html(langData[itemName]);
              }
            });
          }
        }
      }

      $(this).parent().siblings().find(".dropdown-item").removeClass("active");
      $(this).addClass("active");

      if (langType == "ar") {
        SITE_DIRECTION = "rtl";
        document.body.lang = "ar";
        bootstrapFileLink.attr("href", "../css/libs/bootstrap.rtl.css");
        stylesheetFileLink.attr("href", "../css/style.rtl.css");
        dropdownToggler.html("عربي");
      } else {
        SITE_DIRECTION = "ltr";
        document.body.lang = "en";
        bootstrapFileLink.attr("href", "../css/libs/bootstrap.css");
        stylesheetFileLink.attr("href", "../css/style.css");
        dropdownToggler.html("English");
      }

      mainLoader.hide(100);
    });
  });

  // - Init Carousel Discount
  if (discountsSliderWrap.length) {
    discountsSliderWrap.owlCarousel({
      animateOut: "animate__animated animate__fadeOut",
      animateIn: "animate__animated animate__fadeIn",
      items: 1,
      margin: 0,
      dots: true,
      rtl: SITE_DIRECTION === "rtl" ? true : false,
      pullDrag: false,
      mouseDrag: false,
      touchDrag: false,
      loop: false,
      rewind: false,
      autoHeight: true,
      autoplay: true,
    });
  }

  // - navbar , Add blur when scrolling
  mainHeader.css("padding-top", mainNavbar.innerHeight() + "px");
  $(document).on("scroll", function () {
    let winScroll = window.scrollY;
    let mainHeaderHeight = mainHeader.height() - 200;

    if (winScroll >= mainHeaderHeight) {
      mainNavbar.addClass("blur");
    } else {
      mainNavbar.removeClass("blur");
    }
  });

  // Remove The Loading
  mainLoader.hide(100);
});
