import cv2 as cv


img = cv.imread('opencv_image.png', 0)
cv.imshow('Imagem', img)
cv.waitKey(5000)

if cv.waitKey(0) == ord('s'):
    cv.imwrite('opencv_image_gray.png', img)

cv.destroyAllWindows()
